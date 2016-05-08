using ABPS.Data;
using System;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.Globalization;
using System.Linq;
using System.Security.Permissions;
using System.Text;
using System.Threading.Tasks;
using System.Web;

namespace ABPS
{
    public class HttpService : HttpServer
    {

        [PermissionSet(SecurityAction.Demand, Name = "FullTrust")]
        public HttpService(int port)
           : base(port)
       {
         
            
       }

        public void WriteSuccess(HttpProcessor p,byte[] buffer, string content)
        {

            CultureInfo provider = new CultureInfo("en-US");
            p.outputStream.WriteLine("HTTP/1.1 200 OK");
            p.outputStream.WriteLine("Content-Type: " + content);

            p.outputStream.WriteLine("Accept-Ranges: bytes");
            p.outputStream.WriteLine("Server: GhostReplay");
            p.outputStream.WriteLine("Pragma: no-cache");
            p.outputStream.WriteLine("Cash-Control: no-cache");
            p.outputStream.WriteLine("Expires: Thu, 01 Jan 1970 08:00:00 CST");
            p.outputStream.WriteLine("Content-Length: " + buffer.Length.ToString());
            p.outputStream.WriteLine("Date: " + DateTime.UtcNow.ToString("ddd, dd MM yyyy HH:mm:ss GMT", provider));
            p.outputStream.WriteLine("Connection: close");
            p.outputStream.WriteLine("");
            p.outputStream.WriteContent(buffer);
        }
        public override void handleGETRequest(HttpProcessor p)
        {

            if (p.http_url == "/")

                WriteSuccess(p, Encoding.UTF8.GetBytes("<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\"><html><head><title>Access Denied</title></head><body><h1>Access denied</h1><p>You don't have permission to access " + p.http_url + " on this server.</p><hr><address>Arsslensoft Bot Platform - Http Service</address></body></html>"), "text/html");
            else if (p.http_url.StartsWith("/api"))
            {
                NameValueCollection nameValueCollection = HttpUtility.ParseQueryString(p.http_url.Remove(0,5));
                string response = Platform.Api.RedirectRequest(nameValueCollection["method"], nameValueCollection);

                WriteSuccess(p, Encoding.UTF8.GetBytes(response), "application/json");
            }
                
        
        }
        public override void handlePOSTRequest(HttpProcessor p, System.IO.MemoryStream inputData)
        {
            p.writeFailure();
            p.outputStream.WriteLine("ACCESS DENIED");
        }

    }
}
