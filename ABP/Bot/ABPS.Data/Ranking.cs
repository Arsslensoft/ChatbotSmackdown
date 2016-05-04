using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ABPS.Data
{
   public class Ranking : DatabaseObject
    {
        public long? BotId { get; set; }
        public virtual User Bot { get; set; }

        public long? CompetitionId { get; set; }
        public virtual Competition Competition { get; set; }

        public double Rank { get; set; }
    }
}
