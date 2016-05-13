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
         
        }
        private void CreateRound(TournamentRound rnd, ref Round round)
        {
            Platform.Synchronize();
            Platform.LogEvent("Creating round ", ConsoleColor.DarkCyan);

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
                game.Duration = PlatformSettings.GameDuration;
                game.Start = game_start;
                game_start = game_start.AddMinutes(5);
                game.RoundId = round.Id;
                game.Round = round;
                game.WinnerId = 1;
                game.Status = GameStatus.Pending;
                game.ChatHistoryFile = "";
                game.PlayerSleepTime = PlatformSettings.PlayerPause;
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
                if (rd == null || rd.Pairings[0].TeamScores.Count == 1)
                {
                    CurrentRound = null;
                    return false;
                }
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
              
              Platform.LogEvent("Current round started  "+Competition.Name, ConsoleColor.DarkCyan);
         if(CurrentRound != null)
              CurrentRound.Start();


          }
          private void IncrementPlayerScore(Dictionary<long, double> myDict, long player, double score)
          {
              if (myDict.ContainsKey(player))
                  myDict[player] += score;
              else myDict.Add(player, score);
          }
          private void RewardPlayers()
          {
              Platform.Synchronize();
              Platform.LogEvent("Rewarding players "+Competition.Name, ConsoleColor.DarkCyan);
              Dictionary<long, double> myDict = new Dictionary<long, double>();
       

        
              foreach (Round rnd in Competition.Rounds)
              {
                  foreach (Game gm in rnd.Games)
                  {
                      List<Player> won = gm.Players.Where(x => x.BotId == gm.WinnerId).ToList();
                      List<Player> lost = gm.Players.Where(x => x.BotId != gm.WinnerId).ToList();

                
                          IncrementPlayerScore(myDict,won[0].BotId.Value, (double)Competition.PointsPerWin);
                          IncrementPlayerScore(myDict, lost[0].BotId.Value, 0);
                    
                  }
              }

          

              // last win
              Game last_game = Competition.Rounds[Competition.Rounds.Count - 1].Games[0];
              List<Player> swon = last_game.Players.Where(x => x.BotId == last_game.WinnerId).ToList();
           
              IncrementPlayerScore(myDict, swon[0].BotId.Value, (double)Competition.Prize);
         

              var sortedDict = from entry in myDict orderby entry.Value ascending select entry;
              int rank = sortedDict.Count();
              // rank all users
              foreach (KeyValuePair<long, double> pair in sortedDict)
              {
                  List<User> u = Platform.DBManager.Users.Where(x => x.Id == pair.Key).ToList();
                  u[0].BotScore += (long)pair.Value;
                  Ranking rnk = new Ranking();
                  rnk.BotId = u[0].Id;
                  rnk.CompetitionId = Competition.Id;
                  rnk.Rank = rank;

                  Platform.DBManager.Rankings.Add(rnk);
                  rank--;
              }
              Competition.Status = CompetitionStatus.Completed;
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
                {
                    if (Competition.Status == CompetitionStatus.Ready)
                    {
                        Competition.Status = CompetitionStatus.Started;
                        Platform.DBManager.SaveChanges();
                    }
                    StartCurrentRound();
                }
                else
                    RewardPlayers();
               
          
            }
            catch (Exception ex)
            {
                Console.WriteLine("Tournament Job Error : " + ex.Message);
            }
        }
        public override bool IsRepeatable()
        {
            if (CurrentRound != null)
                return CurrentRound.CurrentRound.Pairings[0].TeamScores.Count != 1 || Competition.Status != CompetitionStatus.Completed;
            else
                return Competition.Status != CompetitionStatus.Completed;
        }
        public override bool CanStart()
        {
            return Competition.Start <= DateTime.Now && Competition.Status != CompetitionStatus.Completed;
        }
        public override int GetRepetitionIntervalTime()
        {
            return (int)(PlatformSettings.RoundInterval.TotalMilliseconds);
        }
    }
}
