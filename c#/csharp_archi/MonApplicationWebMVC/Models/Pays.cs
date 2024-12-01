using Microsoft.AspNetCore.Mvc;
using Microsoft.Data.Sqlite;

namespace MonApplicationWebMVC.Models
{
    public class Pays
    {
        public int Id { get; set; }
        public string nom { get; set; }
        public string drapeau { get; set; }
        public string continent { get; set; }
        public int population { get; set; }
        public float superficie { get; set; }
        public string devise { get; set; } = "Dollar";
        public double txConvertion { get; set; } = 0.87947;

        [BindProperty]
        public IFormFile ImportDrapeau {  get; set; }

        public static List<Pays> TousLesPays()
        {
            List<Pays> pays = new List<Pays>();
            pays.Add(new Pays("France", "france.png", "Europe", 68042591, 672051,1));
            pays.Add(new Pays("Suisse", "suisse.png", "Europe", 8703000, 41285,2));
            pays.Add(new Pays("Brésil", "bresil.jpg", "Amérique", 215002523, 8547404,3));
            pays.Add(new Pays("Algérie", "Algeria.png", "Afrique", 44487616, 2381741,4));
            pays.Add(new Pays("Allemagne", "Germany.png", "Europe", 84358845, 357588,5));
            pays.Add(new Pays("Australie", "Australia.png", "Océanie", 26499819, 7741200,6));
            pays.Add(new Pays("Chine", "China.png", "Asie", 1425671352, 9596960,7));
            pays.Add(new Pays("États-Unis", "USA.png", "Amérique", 334914895, 9833517,8));
            pays.Add(new Pays("Mozambique", "Mozambique.png", "Afrique", 215002523, 8547404,9));
            return pays;

        }

        

                public Pays(string nom, string drapeau, string continent, int population, float superficie, int id ) 
        {
            this.nom = nom;
            this.drapeau = drapeau;
            this.continent = continent;
            this.population = population;
            this.superficie = superficie;
            this.Id = id; 
        }

        public Pays()
        {
            this.nom = "Inconnu";
            this.drapeau = "Unknown.png";
            this.continent = "Inconnu";
            this.population = 0;
            this.superficie = 0;
        }
    }

    public enum Continent
    {
        Asie,
        Europe,
        Amérique,
        Afrique,
        Océanie,
        Antarctique 
    }
}
