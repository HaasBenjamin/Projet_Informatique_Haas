using Microsoft.Data.Sqlite;
using Microsoft.EntityFrameworkCore;
using Microsoft.Extensions.Options;
using MonApplicationWebMVC.Models;
namespace MonApplicationWebMVC.Data
{
    public class MonContextEntityFramework : DbContext
    {
        private static readonly bool iscreate = false;
        public virtual DbSet<Pays> Pays { get; set; }

        public string Filepath { get; set; }


        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            CreateDatabase();
            modelBuilder.Entity<Pays>().HasKey(c => c.Id);
            modelBuilder.Entity<Pays>().Ignore(c => c.ImportDrapeau);
        }

        public  void CreateDatabase()
        {
            string text = "DROP TABLE Pays;";
            text += " CREATE TABLE \"Pays\" (\r\n\"Id\" INTEGER NOT NULL UNIQUE,\r\n\"nom\" TEXT,\r\n\"drapeau\" string,\r\n\"devise\" string,\r\n\"txConvertion\" FLOAT, \r\n\"continent\" TEXT,\r\n\"population\" INTEGER,\r\n\"superficie\" INTEGER,\r\nPRIMARY KEY(\"Id\" AUTOINCREMENT)\r\n);";
            text += "INSERT INTO Pays VALUES (1,'France','france.png','Euros',1.0,'Europe',68042591,672051);";
            text += "INSERT INTO Pays VALUES (2,'Suisse','suisse.png','Euros',1.0,'Europe',8703000,41285);";
            text += "INSERT INTO Pays VALUES (3,'Brésil','bresil.jpg','Real',0.19,'Amérique',215002523,8547404);";
            text += "INSERT INTO Pays VALUES (4,'Algérie','Algeria.png','Dinar algérien',0.0068,'Afrique',44487616,2381741);";
            text += "INSERT INTO Pays VALUES (5,'Allemagne','Germany.png','Euros',1.0,'Europe',84358845,357588);";
            text += "INSERT INTO Pays VALUES (6,'Australie','Australia.png','Dollar australien',0.60,'Océanie',26499819,7741200);";
            text += "INSERT INTO Pays VALUES (7,'Chine','China.png','Renminbi',0.13,'Asie',1425671352,9596960);";
            text += "INSERT INTO Pays VALUES (8,'États-Uni','USA.png','Dollar',0.87947,'Amérique',334914895,9833517);";
            text += "INSERT INTO Pays VALUES (9,'Mozambique','Mozambique.png','Metical',0.014,'Afrique',215002523,8547404);";
            using (var connection = new SqliteConnection(
                new SqliteConnectionStringBuilder
                {
                    DataSource = "localDB.db"
                }.ToString()))
            {
                connection.Open();
                using (var transaction = connection.BeginTransaction())
                {
                    var insertCommand = connection.CreateCommand();
                    insertCommand.Transaction = transaction;
                    insertCommand.CommandText = text;
                    insertCommand.ExecuteNonQuery();
                    transaction.Commit();
                }
            }
        }

        protected override void OnConfiguring(DbContextOptionsBuilder optionsBuilder)
        {
            optionsBuilder.UseSqlite($"Filename={Filepath}");
            base.OnConfiguring(optionsBuilder);
        }

        public MonContextEntityFramework(string filepath)
        {
            var builder = WebApplication.CreateBuilder();
            var app = builder.Build();
            Filepath = Path.Combine(app.Environment.ContentRootPath,filepath);
        }
    }
}
