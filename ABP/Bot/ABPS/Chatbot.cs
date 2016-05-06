using ABPS.Aiml;
using ABPS.Data;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Xml;

namespace ABPS
{
  public class Chatbot
    {
      public bool IsInGame { get; set; }
      public string BotPath
      {
          get { return Path.Combine(Environment.CurrentDirectory, "bots", User.Id.ToString());}
      }
      public string PersonalityPath
      {
          get { return Path.Combine(BotPath , "config"); }
      }
      public string AIMLPath
      {
          get { return Path.Combine(BotPath, "aiml"); }
      }
   


      public ABPS.Aiml.User BotUser { get; set; }
      public ABPS.Aiml.Bot BotEngine { get; set; }
      public ABPS.Data.User User { get; set; }
      public List<ABPS.Aiml.User> Visitors { get; set; }
      public Chatbot(ABPS.Data.User user)
      {
          User = user;
          BotEngine = new Bot(BotPath);
         // BotEngine.loadSettings(Path.Combine(BotPath, Path.Combine("config", "Settings.xml")));
          Visitors = new List<ABPS.Aiml.User>();
   
          if (!Directory.Exists(BotPath))
              Directory.CreateDirectory(BotPath);

      }
      private void ReloadPersonality()
      {
          Platform.LogEvent("Loading personality " + User.BotName, ConsoleColor.Gray);
          List<Personality> personalities = Platform.DBManager.Personalities.Where(x => x.BotId == User.Id).ToList();
          foreach (Personality ai in personalities)
          {
              if (ai.Active)
                  BotEngine.loadSettings(Path.Combine(PersonalityPath ,ai.PersonalityFile));
              
          }
      }
      private void ReloadAimlSets()
      {
          Platform.LogEvent("Loading aiml " + User.BotName, ConsoleColor.Gray);
          List<AimlSet> aimls = Platform.DBManager.AimlSets.Where(x => x.BotId == User.Id).ToList();
          foreach (AimlSet ai in aimls)
          {
              if (ai.Load)
              {
                  XmlDocument doc = new XmlDocument();
                  doc.Load(Path.Combine(AIMLPath, ai.AimlFile));
                  BotEngine.loadAIMLFromXML(doc, Path.Combine(AIMLPath, ai.AimlFile));
              }
          }
          //BotEngine.loadAIMLFromFiles();
      }
      public void ReloadBot()
      {

         Platform.LogEvent("Loading bot " + User.BotName, ConsoleColor.Magenta );
          BotEngine = new Bot(BotPath);
          BotEngine.isAcceptingUserInput = false;
          ReloadPersonality();
          ReloadAimlSets();
          BotEngine.isAcceptingUserInput = true;
          Visitors.Clear();
          foreach (Visitor v in User.Visitors)
              AddVisitor(v);
          Platform.LogEvent("Bot " + User.BotName+" loaded", ConsoleColor.DarkMagenta);
      }
      public void InitializeUserBot(Bot opponent)
      {
          BotUser = new Aiml.User(User.BotName + User.Id.ToString(), opponent ,BotPath );
      }
      public void AddVisitor(Visitor vis)
      {
          Visitors.Add(new ABPS.Aiml.User(vis.VisitorIdentifier, BotEngine, BotPath));
      }
      public ABPS.Aiml.User GetVisitor(Visitor v)
      {
          foreach (ABPS.Aiml.User u in Visitors)
              if (u.UserID == v.VisitorIdentifier)
                  return u;

          AddVisitor(v);
          return new ABPS.Aiml.User(v.VisitorIdentifier, BotEngine, BotPath);
      }
      public string Answer(string message, Visitor v)
      {

          Request r = new Request(message, GetVisitor(v), BotEngine);
          Result res = BotEngine.Chat(r);
          return res.Output;
      }
      public string Answer(string message, Chatbot bot)
      {
          Request r = new Request(message, bot.BotUser, BotEngine);
          Result res = BotEngine.Chat(r);
          return res.Output;
      }

    }
}
