using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ABPS.Data
{
    public class Personality : DatabaseObject
    {

        public long? BotId { get; set; }
        public virtual User Bot { get; set; }
        public string PersonalityFile { get; set; }


    }
}
