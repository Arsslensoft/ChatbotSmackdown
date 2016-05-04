﻿using System;
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
        Voting,
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
           Players = new List<Player>();
           Votes = new List<Vote>();
       }
  
        public long? RoundId { get; set; }
        public virtual Round Round { get; set; }

        public GameStatus Status { get; set; }

        public DateTime Start { get; set; }
        
        public TimeSpan Duration { get; set; }
        public TimeSpan PlayerSleepTime { get; set; }

        public GamePlayers Winner { get; set; }

        public string ChatHistoryFile { get; set; }

        [InverseProperty("Game")]
        public virtual List<Vote> Votes { get; set; }

        [InverseProperty("Game")]
        public virtual List<Player> Players { get; set; }

    }
}
