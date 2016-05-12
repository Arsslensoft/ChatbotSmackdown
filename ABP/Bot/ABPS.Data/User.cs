using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Text;

namespace ABPS.Data
{
    public enum UserRole
    {
        User,
        Administrator
    }
   public class User : DatabaseObject
    {
       public string Username { get; set; }
       public string Password { get; set; }
       public string Email { get; set; }
       public string FirstName { get; set; }
       public string LastName { get; set; }
       public UserRole Role { get; set; }
       public string Salt { get; set; }
   
       // Bot part
       public string BotName { get; set; }
       public string BotDescription { get; set; }
       public long BotScore { get; set; }
       public bool BotActive { get; set; }

       public User()
       {
           Personalities = new List<Personality>();
           AimlSets = new List<AimlSet>();
           Participations = new List<Participation>();
           Scores = new List<Player>();
           Visitors = new List<Visitor>();
          /* Votes = new List<Vote>();*/
       }

       // Relationships
       [InverseProperty("Bot")]
       public virtual List<Personality> Personalities { get; set; }

       [InverseProperty("Bot")]
       public virtual List<AimlSet> AimlSets { get; set; }

       [InverseProperty("Bot")]
       public virtual List<Participation> Participations { get; set; }

       [InverseProperty("Bot")]
       public virtual List<Player> Scores { get; set; }

       [InverseProperty("Bot")]
       public virtual List<Visitor> Visitors { get; set; }


    /*   [InverseProperty("Bot")]
       public virtual List<Vote> Votes { get; set; }*/


       [InverseProperty("Bot")]
       public virtual List<Ranking> Rankings { get; set; }

    }
}
