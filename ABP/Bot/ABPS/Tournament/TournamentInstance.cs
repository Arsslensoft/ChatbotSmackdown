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
  public  class TournamentInstance : Job
    {

      public Thread TournamentThread { get; set; }
      public TimeSpan GameDuration { get; set; }
      public RoundInstance CurrentRound { get; set; }
      public Tournaments.Standard.EliminationTournament Manager { get; set; }
      public Competition Competition;

        public List<Tournaments.TournamentTeam> Teams { get; set; }
        public List<Tournaments.TournamentRound> Rounds { get; set; }
        public List<RoundInstance> ExecutedRounds { get; set; }
        public List<GameInstance> ExecutedGames { get; set; }

        public TournamentInstance(Competition comp)
        {
            Teams = new List<Tournaments.TournamentTeam>();
            Rounds = new List<Tournaments.TournamentRound>();
            Manager = new Tournaments.Standard.EliminationTournament(1);
            ExecutedRounds = new List<RoundInstance>();
            ExecutedGames = new List<GameInstance>();
            Competition = comp;
            GameDuration = new TimeSpan(0, 1, 0);
        }
        private void CreateRound(TournamentRound rnd, ref Round round)
        {

             round = new Round();
            round.CompetitionId = Competition.Id;
            round.Competition = Competition;
            round.Number = Competition.Rounds.Count;

      
            DateTime game_start = Competition.Start.AddDays(Competition.Rounds.Count);
            Platform.DBManager.Rounds.Add(round);
            // create games
            foreach (TournamentPairing pair in rnd.Pairings)
            {
                Game game = new Game();
                game.Duration = GameDuration;
                game.Start = game_start;
                game_start = game_start.AddMinutes(5);
                game.RoundId = round.Id;
                game.Round = round;
                game.Winner = GamePlayers.Unknown;
                game.Status = GameStatus.Pending;
                game.ChatHistoryFile = "";
                game.PlayerSleepTime = new TimeSpan(0, 0, 2);
                Platform.DBManager.Games.Add(game);
                // Create players
                foreach (TournamentTeamScore team in pair.TeamScores)
                {
                    Player player = new Player();
                    player.BotId = team.Team.TeamId;
                    player.GameId = game.Id;
                    player.Game = game;

                    Platform.DBManager.Players.Add(player);
                }


            }

            Platform.DBManager.SaveChanges();



        }
         private bool CreateNextRound()
        {
            if (CurrentRound != null)
                CurrentRound.CheckResults();
               
            

            if (Teams.Count == 0 && Competition.ParticipantNumber == Competition.Participations.Count)
            {
                foreach (Participation part in Competition.Participations)
                    AddPlayer(part.Bot);
            }
           
                Manager.Reset();
                Manager.LoadState(Teams, Rounds);

                TournamentRound rd = Manager.CreateNextRound(null);
                // Finals
                if (rd.Pairings[0].TeamScores.Count == 1)
                    return false;
                else
                {
                    Round round = null;
                    CreateRound(rd, ref round);

                    RoundInstance ri = new RoundInstance(Competition, rd, round, this);
                    ExecutedRounds.Add(CurrentRound);
                    CurrentRound = ri;
                    Rounds.Add(CurrentRound.CurrentRound);
                    return true;
                }

            
        }
          private void AddPlayer(User user)
        {
            Teams.Add(new Tournaments.TournamentTeam(user.Id, user.BotScore));
        }
          private void StartCurrentRound()
          {

         if(CurrentRound != null)
              CurrentRound.Start();


          }
          private void RewardPlayers()
          {
           
              foreach (TournamentRanking rank in Manager.GenerateRankings())
              {
                  List<User> u = Platform.DBManager.Users.Where(x => x.Id == rank.Team.TeamId).ToList();
                  u[0].BotScore = (long)((Competition.ParticipantNumber - rank.Rank) * Competition.Prize);


                  Ranking rnk = new Ranking();
                  rnk.BotId = u[0].Id;
                  rnk.CompetitionId = Competition.Id;
                  rnk.Rank = rank.Rank;

                  Platform.DBManager.Rankings.Add(rnk);
              }
              Platform.DBManager.SaveChanges();

          }

      

        public override string GetName()
        {
            return this.GetType().Name;
        }
        public override void DoJob()
        {
            try
            {
                if (CreateNextRound())
                    StartCurrentRound();
                else RewardPlayers();
            }
            catch (Exception ex)
            {
                Console.WriteLine("Tournament Job Error : " + ex.Message);
            }
        }
        public override bool IsRepeatable()
        {
            if (CurrentRound != null)
                return CurrentRound.CurrentRound.Pairings[0].TeamScores.Count != 1;
            else
                 return true;
        }
        public override bool CanStart()
        {
            return Competition.Start <= DateTime.Now && Competition.Status != CompetitionStatus.Completed;
        }
        public override int GetRepetitionIntervalTime()
        {
            return (int)(new TimeSpan(23,59,0).TotalMilliseconds);
        }
    }
}
