using System;
using System.Data.Common;
using System.Data.Entity;

namespace ABPS.Data
{
    public class ChatbotSmackdownDb : DbContext
    {
        static ChatbotSmackdownDb()
        {
     //   Database.SetInitializer<ChatbotSmackdownDb>(new CreateDatabaseIfNotExists<ChatbotSmackdownDb>());

       Database.SetInitializer<ChatbotSmackdownDb>(null);
        }

        public ChatbotSmackdownDb() : base(CreateConnection(), true)
        {

        }

        public ChatbotSmackdownDb(string connectionString) : base(connectionString)
        {
        }

        public ChatbotSmackdownDb(DbConnection connection) : base(connection, true)
        {
           
        }


        public DbSet<Participation> Participations { get; set; }
        public DbSet<User> Users { get; set; }
        public DbSet<Game> Games { get; set; }
        public DbSet<Personality> Personalities { get; set; }
        public DbSet<AimlSet> AimlSets { get; set; }
        public DbSet<Competition> Competitions { get; set; }
        public DbSet<Visitor> Visitors { get; set; }
        public DbSet<Round> Rounds { get; set; }
        public DbSet<Player> Players { get; set; }
        public DbSet<Ranking> Rankings { get; set; }


        private static DbConnection CreateConnection()
        {
            ChatbotSmackdownConfigurationManager.Initialize();
            var connection = DbProviderFactories.GetFactory("MySql.Data.MySqlClient").CreateConnection();
            connection.ConnectionString = string.Format("Server={0};Database={1};Uid={2};Pwd={3};Port={4}",
               ChatbotSmackdownConfigurationManager.Configuration.Host, ChatbotSmackdownConfigurationManager.Configuration.Database,
                ChatbotSmackdownConfigurationManager.Configuration.User, ChatbotSmackdownConfigurationManager.Configuration.Password,
                ChatbotSmackdownConfigurationManager.Configuration.Port);
            return connection;
        }
    }

    public class DatabaseVersion : DatabaseObject
    {
        public DateTime Date { get; set; }
    }
}