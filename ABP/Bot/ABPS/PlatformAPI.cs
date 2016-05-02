using ABPS.Data;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ABPS
{
   public class PlatformAPI
    {
       public string ErrorMessage = "{\"status\":\"{0}\",\"error\":\"{1}\"}";
       public PlatformAPI()
       {

       }

      
       public string GetBotStatus(string id)
       {
           try

           {
               long bid =long.Parse(id);
               List<User> bots = Platform.DBManager.Users.Where(x => x.Id == bid ).ToList();
               if (bots.Count > 0)
                   return JsonConvert.SerializeObject(new BotStatusResponse("OK", bots[0].Id, bots[0].BotActive));

               else
                   return JsonConvert.SerializeObject(new ErrorResponse("BOT_NOT_EXIST", "This bot does not exist"));
           }
           catch (Exception ex)
           {
               return JsonConvert.SerializeObject(new ErrorResponse("FAILED",ex.Message));
           }
         
       }
       public string RedirectRequest(string method, NameValueCollection nvc)
       {
           if (method == "status" && nvc["id"] != null)
               return GetBotStatus(nvc["id"]);

           else return JsonConvert.SerializeObject(new ErrorResponse("NOT_SUPPORTED", "This method is not supported by the platform"));
        
       }
    }
}
