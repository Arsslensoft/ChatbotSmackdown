using System;
using System.IO;
using Newtonsoft.Json;

namespace ABPS.Data
{
    public class ChatbotSmackdownConfig
    {
        public string Host { get; set; }
        public string Password { get; set; }
        public string User { get; set; }
        public string Database { get; set; }
        public int Port { get; set; }
    }

    public static class ChatbotSmackdownConfigurationManager
    {
        public static ChatbotSmackdownConfig Configuration { get; set; }

        public static void Initialize()
        {
            //TODO:replace with safe
            try
            {
                var json = File.ReadAllText(Path.Combine(Environment.CurrentDirectory, @"Data\db_config.json"));
                Configuration = JsonConvert.DeserializeObject<ChatbotSmackdownConfig>(json);
            }
            catch
            {
            }
        }
    }
}