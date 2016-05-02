using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Text;

namespace ABPS.Data
{
    public enum GameStatus
    {
        Pending,
        Playing,
        Completed
        
    }
    public enum GamePlayers
    {
        Unknown,
       First,
        Second

    }
   public class Game : DatabaseObject
    {

       public Game()
       {
           Scores = new List<UserScore>();
       }
       public Game(UserScore teamA,UserScore teamB)
        {
            Scores = new List<UserScore>();
            teamA.GameId = Id;
            teamB.GameId = Id;
            teamA.Game = this;
            teamB.Game = this;
            Scores.Add(teamA);
            Scores.Add(teamB);
        }
        public long? RoundId { get; set; }
        public virtual Round Round { get; set; }

        public GameStatus Status { get; set; }

        public DateTime Start { get; set; }
        
        public TimeSpan Duration { get; set; }

        public GamePlayers Winner { get; set; }

  


        [InverseProperty("Game")]
        public virtual List<UserScore> Scores { get; set; }

    }
}
