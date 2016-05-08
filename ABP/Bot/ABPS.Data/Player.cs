using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Text;

namespace ABPS.Data
{
   public class Player : DatabaseObject
    {
  
       public long? GameId { get; set; }
       public virtual Game Game { get; set; }

       public long? BotId { get; set; }
       public virtual User Bot { get; set; }

       public double Score { get; set; }
       public long Votes { get; set; }
     

    }
}
