using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ABPS
{
   public class Response
    {
       [JsonProperty("code")]
       public string Code { get; set; }
       public Response(string code)
       {
           Code = code;
       }
    }

   public class ErrorResponse : Response
   {
       public string error { get; set; }
       public ErrorResponse(string code, string error)
           : base(code)
       {
           this.error = error;
       }
   }
   public class BotStatusResponse : Response
   {
       public int status { get; set; }
       public long bot { get; set; }
       public BotStatusResponse(string code, long id, bool active) : base(code)
       {
           bot = id;
           status = active ? 1 : 0;

       }
   }
}
