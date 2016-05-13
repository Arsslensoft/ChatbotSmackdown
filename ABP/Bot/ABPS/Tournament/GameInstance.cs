using ABPS.Data;
using ABPS.Tournaments;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading;
using System.Threading.Tasks;

namespace ABPS
{
    public enum GameCommand
    {
        START_GAME,
        INTERRUPT
    }
  
    public delegate void GameEventHandler(Game game,GameCommand command);
    public class GameInstance
    {
      public event GameEventHandler OnGameCommand;


      public static Random Generator = new Random();
      public Competition Competition;
      public Game Game;
      public TournamentRound CurrentRound;
      public TournamentPairing Pairing;
      public GameDriver Driver { get; set; }
      public GameInstance(Game game, Competition comp, TournamentRound round, TournamentPairing pair)
      {
          Game = game;
          Competition = comp;
          CurrentRound = round;
          Pairing = pair;
      }

      public long GetVoteCount(long? id)
      {
        return Game.Players.Where(x => x.BotId == id).ToList()[0].Votes;
 
      }
        /// <summary>
        /// Start's a game
        /// </summary>
      public void StartGame()
      {
          try
          {
          

                  if (OnGameCommand != null)
                      OnGameCommand(Game, GameCommand.START_GAME);

                  Platform.Synchronize();

                  Game.Status = GameStatus.Playing;
                  Platform.DBManager.SaveChanges();
                  Driver = new GameDriver(Game);
                  // Initialize Game
                  Driver.InitializeGame();
              // launch game
                  Driver.StartChat();

                  if (OnGameCommand != null)
                      OnGameCommand(Game,GameCommand.INTERRUPT);

                  Driver.FinalizeGame();
                  Game.Status = GameStatus.Voting;
                  Platform.DBManager.SaveChanges();

              
          }
          catch (Exception ex)
          {
              Console.WriteLine("Game error : "+ex.Message);
          }
      }

      public bool GetTeamFromPairing(long? bot, ref TournamentTeamScore team)
      {
          team = null;
          foreach (TournamentPairing pair in CurrentRound.Pairings)
          {
              foreach (TournamentTeamScore tts in pair.TeamScores)
                  if (tts.Team.TeamId == bot)
                  {
                      team = tts;
                      return true;
                  }
          }
          return false;
      }

        /// <summary>
        /// Get's results of a game
        /// </summary>
      public void CloseVoteAndSetResult()
      {
          Platform.Synchronize();
          Game.Status = GameStatus.Completed;

          // get votes
          long first_votes = GetVoteCount(Game.Players[0].BotId);
          long second_votes = GetVoteCount(Game.Players[1].BotId);
          // set scores
          Game.Players[0].Score = first_votes * 100;
          Game.Players[1].Score = second_votes * 100;

          if (first_votes == second_votes)
          {
              if (Generator.Next(0, 1) == 1)
              {
                  Game.WinnerId = Game.Players[1].BotId;
                  Game.Players[1].Score += Competition.PointsPerWin;
              }
              else
              {
                  Game.WinnerId = Game.Players[0].BotId;
                  Game.Players[0].Score += Competition.PointsPerWin;
              }
              
          }
          else if (first_votes > second_votes)
          {
              Game.WinnerId = Game.Players[0].BotId;
              Game.Players[0].Score += Competition.PointsPerWin;
          }
          else
          {
              Game.WinnerId = Game.Players[1].BotId;
              Game.Players[1].Score += Competition.PointsPerWin;
          }


          Platform.DBManager.SaveChanges();

          // Set rounds
          TournamentTeamScore first = null;
          TournamentTeamScore second = null;
          GetTeamFromPairing(Game.Players[0].BotId, ref first);
          GetTeamFromPairing(Game.Players[1].BotId, ref second);

          first.Score = new HighestPointsScore(Game.Players[0].Score);
          second.Score = new HighestPointsScore(Game.Players[1].Score);


      }
      
    }
}
