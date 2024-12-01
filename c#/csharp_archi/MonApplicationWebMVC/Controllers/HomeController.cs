using Microsoft.AspNetCore.Hosting;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore.ChangeTracking;
using MinimalWebAPI1;
using MonApplicationWebMVC.Data;
using MonApplicationWebMVC.Models;
using System.Diagnostics;
using System.Net;
using System.Text;

namespace MonApplicationWebMVC.Controllers
{
    public class HomeController : Controller
    {
        private readonly ILogger<HomeController> _logger;

        public HomeController(ILogger<HomeController> logger, IWebHostEnvironment webHostEnvironment)
        {
            _logger = logger;
            _webHostEnvironment = webHostEnvironment;
        }

        public IActionResult Index()
        {
            return View();
        }

        public IActionResult Privacy()
        {
            return View();
        }

        [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
        public IActionResult Error()
        {
            return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
        }
        public IActionResult HealthCheck()
        {
            return Ok();
        }
        public EmptyResult RetourVide()
        {
            return new EmptyResult();
        }
        public HttpStatusCode RetourStatus()
        {
            return HttpStatusCode.OK;
        }
        public string RetourString()
        {
            return "test";
        }
        public JsonResult RetourJson()
        {
            UnObjetDeRetour unObjet = new UnObjetDeRetour()
            { Code = 1, Message = "test", Criticite = "eleve"};
            return new JsonResult(unObjet);
        }
        public ContentResult RetourContent()
        {
            return new ContentResult();
        }
        [HttpGet]
        public IActionResult Divise([FromQuery] float dividende, [FromQuery] float diviseur)
        {
            return Content($"Le résultat de la division de {dividende} par {diviseur} " + (dividende / diviseur).ToString());
        }
        [HttpGet]
        public IActionResult Double([FromQuery] int nombre)
        {
            return Content($"Le double de {nombre} est " + (nombre * 2).ToString());
        }

        [HttpGet]
        public FileStreamResult RetournerUnFichier()
        {
            string filename = "test.txt";
            FileStream fs = System.IO.File.OpenRead(filename);
            return File(fs, "application/octet-stream", filename);
        }

        [HttpGet]
        public ContentResult RetournerPageDynamique()
        {
            StringBuilder sb = new StringBuilder();
            sb.Append("<!DOCTYPE html>");
            sb.Append("<html>");
            sb.Append("<head>");
            sb.Append("<meta charset=\"utf-8\" />");
            sb.Append("<title></title>");
            sb.Append("</head>");
            sb.Append("<body>");
            sb.Append("Exemple de page HTML dynamique ! \n");
            for (int i = 2; i <= 20; i += 2)
            {
                sb.Append($"<div>{i}</div> \n");
            }
            sb.Append("</body>");
            sb.Append("</html>");
            string htmlString = sb.ToString();
            return Content(htmlString, "text/html");
        }

        [HttpGet]
        public ViewResult RetournerUneVue()
        {
            return View();
        }

        [HttpGet]
        public ViewResult VueListePays()
        {
            return View("VueListePays", _pays);
        }

        [HttpGet]
        public ViewResult VuePays(string nom) 
        {
            return View("VuePays", _pays.Find(x => x.nom == nom));
        }

        [HttpGet]
        public IActionResult MonFormulaire()
        {
            return View();
        }


        [HttpPost]
        public IActionResult MonFormulairePoste(IFormCollection form) 
        {
            return View("MonFormulaire");
        }

        [HttpGet]
        public ViewResult AjouterPays()
        {
            Pays pays = new Pays();
            return View("VueAjouterPays",pays);
        }

        private readonly static List<Pays> _pays = Pays.TousLesPays();

        public Pays RecupererLePays(int id)
        {
            using (MonContextEntityFramework cef = new MonContextEntityFramework("localDB.db"))
            {
                return cef.Pays.Where((pay) => pay.Id == id).ToList()[0];
            }                
        }


        [HttpPost]
        public ViewResult AjouterPaysPost(Pays paysPost)
        {
            bool drap = false;
            if (paysPost.ImportDrapeau != null)
            {
                drap = true;
                string filePath = Path.Combine(_webHostEnvironment.WebRootPath, "Content", paysPost.ImportDrapeau.FileName);
                using (var fileStream = new FileStream(filePath, FileMode.Create))
                {
                    paysPost.ImportDrapeau.CopyTo(fileStream);
                }
                paysPost.drapeau = paysPost.ImportDrapeau.FileName;
            }
            paysPost.Id = _pays.Count +1;

            _pays.Add(paysPost);
            List<Pays> tousLesPays = new List<Pays>();

            using (MonContextEntityFramework cef = new MonContextEntityFramework("localDB.db"))
            {
                var pays = cef.Pays.Where(pays => pays.nom == paysPost.nom).ToList();
                if (pays.Count > 0)
                {
                    EntityEntry<Pays> entry = cef.Entry(pays[0]);
                    pays[0].continent = paysPost.continent;
                    pays[0].population = paysPost.population;
                    pays[0].superficie = paysPost.superficie;
                    pays[0].devise = paysPost.devise;
                    pays[0].txConvertion = paysPost.txConvertion;
                    entry.Property(p => p.superficie).IsModified = true;
                    entry.Property(p => p.population).IsModified = true;
                    entry.Property(p => p.continent).IsModified = true;
                    entry.Property(p => p.devise).IsModified = true;
                    entry.Property(p => p.txConvertion).IsModified = true;
                    if (drap)
                    {
                        entry.Property(p => p.drapeau).IsModified = true;
                        pays[0].drapeau = paysPost.drapeau;

                    }
                    cef.Entry(pays[0]).State = Microsoft.EntityFrameworkCore.EntityState.Modified;
                }
                else
                {
                    cef.Pays.Add(paysPost);
                }
                cef.SaveChanges();
                tousLesPays = cef.Pays.ToList();
            }

            return View("VueListePays", tousLesPays);
        }

        //[HttpPost]
        //public ViewResult AjouterPaysPost(IFormCollection paysPost)
        //{
        //    var paysDrapeau = paysPost["ImportDrapeau"];
        //    return new ViewResult();
        //}

        //[HttpPost]
        //public ViewResult AjouterPaysPost(IFormFile paysPost)
        //{
        //   //  var paysDrapeau = paysPost["ImportDrapeau"];
        //    return new ViewResult();
        //}


        private IWebHostEnvironment _webHostEnvironment;

        [HttpPost]
        public void ImportExcel(IFormFile excelFile)
        {
            string filePath = Path.Combine(_webHostEnvironment.WebRootPath, "images", excelFile.FileName);
            using (var fileStream = new FileStream(filePath, FileMode.Create))
            {
                excelFile.CopyTo(fileStream);
            }

        }

        [HttpGet]
        public ViewResult AccessDatabase()
        {
            List<Pays> tousLesPays = new List<Pays>();
            using ( MonContextEntityFramework cef = new MonContextEntityFramework("localDB.db"))
            {
                tousLesPays = cef.Pays.ToList();
            }
            return View("VuelistePays", tousLesPays);
        }

        [HttpGet]
        public ViewResult AccessDatabaseFrance()
        {
            using (MonContextEntityFramework cef = new MonContextEntityFramework("localDB.db"))
            {
                var PaysFrance = cef.Pays.Where(pays => pays.nom == "France").ToList();
                return View("VuelistePays", PaysFrance);
            }
            
        }

        public void SupprimerPays(int id)
        {
            using (MonContextEntityFramework cef = new MonContextEntityFramework("localDB.db"))
            {
                Pays pays = RecupererLePays(id);
                cef.Entry(pays).State = Microsoft.EntityFrameworkCore.EntityState.Deleted;
                cef.SaveChanges();
            }

                
        }

        [HttpGet]
        public ViewResult SuppressPays(int id)
        {
            List<Pays> tousLesPays = new List<Pays>();

            using (MonContextEntityFramework cef = new MonContextEntityFramework("localDB.db"))
            {
                SupprimerPays(id);
                tousLesPays = cef.Pays.ToList();
                return View("VuelistePays", tousLesPays);
            }
        }

        [HttpGet]
        public ViewResult ModifierPays(int id)
        {
            Pays pays = RecupererLePays(id);
            return View("VueAjouterPays", pays);
        }

        [HttpPost]
        public ActionResult _AjaxConversionDeviseToEuro(string MontantEnDevise, string devise)
        {
            switch (devise) { 
                case "Dollar":
                    return new JsonResult(float.Parse(MontantEnDevise) * 0.87947);
                case "Dinar algérien":
                    return new JsonResult(float.Parse(MontantEnDevise) * 0.0068);
                case "Dollar australien":
                    return new JsonResult(float.Parse(MontantEnDevise) * 0.60);
                case "Real":
                    return new JsonResult(float.Parse(MontantEnDevise) * 0.19);
                case "Renminbi":
                    return new JsonResult(float.Parse(MontantEnDevise) * 0.13);
                case "Metical":
                    return new JsonResult(float.Parse(MontantEnDevise) * 0.014);
                default:
                    return null;
            }
        }
        [HttpPost]
        public ActionResult _AjaxConversionDeviseToEuroWithTaux(string MontantEnDevise, string taux)
        {
            return new JsonResult(float.Parse(MontantEnDevise) * float.Parse(taux));
        }

        [HttpPost]  
        public ActionResult _AjaxSupprimerPays(int paysId)
        {
            if (paysId >= 0) {
                SupprimerPays(paysId);
            }
            return Ok();
        }

        [HttpGet]
        public IActionResult Chat()
        {
            return View();
        }

    }
}
