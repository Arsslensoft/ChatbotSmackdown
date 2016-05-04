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
   public class RoundInstance
    {
       public Competition Competition;
        public TournamentRound CurrentRound;
        public Round Round;
        public TournamentInstance TInstance { get; set; }
        public List<GameInstance> GameInstances { get; set; }

        public RoundInstance(Competition comp, TournamentRound round, Round rd, TournamentInstance ti)
        {
            CurrentRound = round;
            Competition = comp;
            GameInstances = new List<GameInstance>();
            Round = rd; 
            TInstance = ti;
        }


        public bool GetPairing(long? bot, ref TournamentPairing team)
        {
            team = null;
            foreach (TournamentPairing pair in CurrentRound.Pairings)
            {
                foreach (TournamentTeamScore tts in pair.TeamScores)
                    if (tts.Team.TeamId == bot)
                    {
                        team = pair;
                        return true;
                    }
            }
            return false;
        }

         /// <summary>
       /// Start all games
       /// </summary>
        public void Start()
        {
           TournamentPairing pair = null;
            // start all games
            foreach (Game game in Round.Games)
            {
                if (GetPairing(game.Players[0].BotId, ref pair))
                {
                    GameInstance gi = new GameInstance(game, Competition, CurrentRound, pair);
                    GameInstances.Add(gi);
                    TInstance.ExecutedGames.Add(gi);
                    gi.StartGame();
                    Thread.Sleep(300000); // wait 5 minutes
                }
            }
   
        }

          /// <summary>
       /// Close games votes
       /// </summary>
        public void CheckResults()
        {
            foreach (GameInstance gi in GameInstances)
                gi.CloseVoteAndSetResult();
        }

    }
}
