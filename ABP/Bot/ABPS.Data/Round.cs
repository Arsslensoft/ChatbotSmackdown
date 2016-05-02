﻿using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Text;

namespace ABPS.Data
{
   public class Round : DatabaseObject
    {
       public long? CompetitionId { get; set; }
       public virtual Competition Competition { get; set; }


       public Round()
       {
           this.Games = new List<Game>();
       }
       public int Number { get; set; }
       public Round(IEnumerable<Game> games)
        {
            if (games == null)
            {
                throw new ArgumentNullException("games");
            }

            this.Games = new List<Game>(games);
        }

       [InverseProperty("Round")]
       public virtual List<Game> Games { get; set; }

    }
}