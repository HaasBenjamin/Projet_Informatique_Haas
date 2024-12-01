using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Xml.Linq;

namespace MoteurDeBatailleNavale
{
    public class GestionnaireDesScores
    {
        public List<Score> TousLesScores {  get;  }

        public GestionnaireDesScores()
        { 
        TousLesScores= new List<Score>();
        }

        public void EnregistrerUnNouveauScore(Score nouveauScore)
        {
            string name = "Liste_Score.txt" ;
            TousLesScores.Add(nouveauScore);
            FileStream filestr;
            if (!File.Exists("Liste_Score.txt"))
            {
                
                filestr = new FileStream(name,FileMode.CreateNew,FileAccess.Write);
            }
            else
            {
                filestr = new FileStream(name, FileMode.Append, FileAccess.Write);
            }
            using (System.IO.StreamWriter file = new System.IO.StreamWriter(filestr))
            {
                string s = JsonConvert.SerializeObject(nouveauScore);
                file.WriteLine(s);
            }
        }

        public void ChargerLesScoresPrécédents()
        {
            
            if (File.Exists("Liste_Score.txt"))
            {
                string name = "Liste_Score.txt";
                FileStream filestr = new FileStream(name, FileMode.Open, FileAccess.Read);
                using (System.IO.StreamReader file = new System.IO.StreamReader(filestr))
                {
                    string line;
                    while ((line = file.ReadLine()) != null)
                    {
                        TousLesScores.Add(JsonConvert.DeserializeObject<Score>(line));
                    }
                    
                }
            }

            
        }

        public void InitialisationAléatoireDeScores()
        {
            Random r = new Random((int)DateTime.Now.Ticks);
            for (int x = 0; x < 100; x++)
            {
                Score nouveauScore = new Score();

                string[] joueurs = new string[] { "Joueur 1", "Joueur 2", "Joueur 3","Joueur 4", "Joueur 5", "Joueur 6" };
                nouveauScore.PseudoGagnant = joueurs[r.Next(6)];
                nouveauScore.PseudoPerdant = joueurs[r.Next(6)];
                nouveauScore.DateEtHeureDePartie = DateTime.Now;
                nouveauScore.NbTirs = r.Next(100);
                EnregistrerUnNouveauScore(nouveauScore);
            }
        }

        public Score MeilleurScoreDeTousLesTemps_V1()
        {
            int mini_tirs = -1;
            int mini_ind = 0;
            for (int x = 0;x < TousLesScores.Count;x++) 
            {
            if (mini_tirs == -1 || TousLesScores[x].NbTirs < mini_tirs)
                {
                    mini_tirs = TousLesScores[x].NbTirs;
                    mini_ind = x;
                }
            }
            return TousLesScores[mini_ind];

        }

        int CléDeTriDesScoresParNombreDeTirs(Score unScore)
        {
            return unScore.NbTirs;
        }
        public Score MeilleurScoreDeTousLesTemps_V2
        {
            get
            {
                return
               TousLesScores.OrderBy(CléDeTriDesScoresParNombreDeTirs).FirstOrDefault();
            }
        }

        public Score MeilleurScoreDeTousLesTemps_V3
        {
            get
            {
                return TousLesScores.OrderBy(scoreATrier =>
               scoreATrier.NbTirs).FirstOrDefault();
            }
        }
    }
}
