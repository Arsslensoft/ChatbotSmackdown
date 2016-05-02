using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Text;

namespace ABPS.Data
{
   public class UserScore : DatabaseObject
    {
           public UserScore()
           {
           }
       public UserScore(User user, Score sc)
       {
           if (sc == null)
               GameScore = 0;
           else GameScore = (sc as HighestPointsScore).Points;


           BotId = user.Id;
           Bot = user;
       }
       public long? GameId { get; set; }
       public virtual Game Game { get; set; }

       public long? BotId { get; set; }
       public virtual User Bot { get; set; }

       public double GameScore { get; set; }

       [NotMapped]
       public Score Score
       {
           get
           {
               return new HighestPointsScore(GameScore==null?0:GameScore);
           }
       }

    }
}
