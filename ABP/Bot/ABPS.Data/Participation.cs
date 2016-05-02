using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Text;

namespace ABPS.Data
{
   public class Participation : DatabaseObject
    {
       public long? BotId { get; set; }
       public virtual User Bot { get; set; }

       public long? CompetitionId { get; set; }
       public virtual Competition Competition { get; set; }

       public DateTime JoinDate { get; set; }




    }
}
