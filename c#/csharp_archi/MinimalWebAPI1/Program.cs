using System.Net.Mime;
using System.Text;

namespace MinimalWebAPI1
{
    public class Program
    {
        public static void HealthCheck()
        {
            throw new Exception("Une erreur est survenue !");
        }

        public static IResult RetournerLeDouble(int unNombre)
        {
            return Results.Text($"Le double de {unNombre} est " + (unNombre * 2).ToString());
        }

        public static IResult RetournerUneChaine()
        {
            return Results.Text("Bonjour, Minimal API en .NetCore");
        }

        public static IResult RetournerUnObjetJson()
        {
            UnObjetDeRetour objet = new UnObjetDeRetour()
            { Code = 45, Message = "Traitement effectué", Criticite = "Elevée"};
            return Results.Json(objet);

        }

        public static Task RetournerUneChaineDeCaractereUtf8(HttpContext httpContext)
        {
            string uneChaineDeCaractereUtf8 = "Une chaîne de caractère UTF8";
            UTF8Encoding utf8 = new UTF8Encoding();
            httpContext.Response.StatusCode = 200;
            httpContext.Response.ContentType = MediaTypeNames.Text.Plain;
            httpContext.Response.ContentLength = Encoding.UTF8.GetByteCount(uneChaineDeCaractereUtf8);
            return httpContext.Response.WriteAsync(uneChaineDeCaractereUtf8, UTF8Encoding.UTF8);


        }

        public static IResult RetourneDivision(float dividende, float diviseur)
        {
            return Results.Text($"{dividende} / {diviseur} = " + (dividende / diviseur).ToString());
        }
        public static void Main(string[] args)
        {
            var builder = WebApplication.CreateBuilder(args);

            // Add services to the container.
            builder.Services.AddAuthorization();


            var app = builder.Build();

            // Configure the HTTP request pipeline.

            app.UseAuthorization();

            var summaries = new[]
            {
                "Freezing", "Bracing", "Chilly", "Cool", "Mild", "Warm", "Balmy", "Hot", "Sweltering", "Scorching"
            };


            app.MapGet("/weatherforecast", (HttpContext httpContext) =>
            {
                var forecast = Enumerable.Range(1, 5).Select(index =>
                    new WeatherForecast
                    {
                        Date = DateTime.Now.AddDays(index),
                        TemperatureC = Random.Shared.Next(-20, 55),
                        Summary = summaries[Random.Shared.Next(summaries.Length)]
                    })
                    .ToArray();
                return forecast;
            });
            app.MapGet("/HealthCheck", HealthCheck);
            app.MapGet("/UneChaine", RetournerUneChaine);
            app.MapGet("/UneChaineUtf8", RetournerUneChaineDeCaractereUtf8);
            app.MapGet("/UnObjetJson", RetournerUnObjetJson);
            app.MapGet("/CalculDouble/{unNombre}", RetournerLeDouble);
            app.MapGet("/Divise", RetourneDivision);

            app.Run();
        }
    }
}
