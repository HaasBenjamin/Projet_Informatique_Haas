using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace MoteurDeBatailleNavale
{
    public class UnJoueurHumainDerrièreLaConsole : IContratDuJoueurDeBatailleNavale
    {


        public string Pseudo
        {
            get;
        }

        public UnJoueurHumainDerrièreLaConsole()
        {
            Console.WriteLine("Entrez un pseudo : ");
            string pseudo = Console.ReadLine() ?? "joueur";
            this.Pseudo = pseudo;
        }

        public void PréparerLaBataille() { }

        public CoordonnéesDeBatailleNavale Attaquant_ChoisirLesCoordonnéesDeTir()
        {
            char[] colposs = CoordonnéesDeBatailleNavale.colposs;
            byte[] ligneposs = CoordonnéesDeBatailleNavale.ligneposs;
            bool correct = false;
            char colonne = ' ';
            byte ligne = 0;
            do
            {
                Console.WriteLine($"{this.Pseudo}, entrez une case : ");
                string rep = Console.ReadLine() ?? "";
                string col = rep.Substring(0, 1);
                col = col.ToUpper();
                string lig = rep.Substring(1);
                colonne = char.Parse(col);
                ligne = byte.Parse(lig);
                foreach (char elt in colposs)
                {
                    if (elt == colonne)
                    {
                        correct = true;
                        break;
                    }
                }

                if (!correct)
                {
                    Console.WriteLine("Mauvaise saisie");
                }
                else
                {
                    foreach (byte elt in ligneposs)
                    {
                        if (elt == ligne)
                        {
                            correct = true;
                            break;
                        }
                    }

                    if (!correct)
                    {
                        Console.WriteLine("Mauvaise saisie");
                    }
                }

            } while (!correct);
            
            return new CoordonnéesDeBatailleNavale(colonne, ligne);
        }

        public RésultatDeTir Défenseur_FournirLeRésultatDuTir(CoordonnéesDeBatailleNavale coord)
        {
            Console.WriteLine($"Votre adversaire a tiré en ({coord.Colonne},{coord.Ligne}) ");
            Console.WriteLine($"Réponse possibles: ");
            Console.WriteLine($"{RésultatDeTir.Touché}/{RésultatDeTir.TouchéCoulé}/{RésultatDeTir.TouchéCouléFinal}/{RésultatDeTir.Raté}");
            bool correct = false;
            string answ = "";
            do
            {
                Console.WriteLine($"{this.Pseudo}, entrez  votre réponse  ");
                answ = Console.ReadLine();
                answ = answ.ToUpper();
                foreach (string elt in Enum.GetNames(typeof(RésultatDeTir)))
                {
                    if (elt.ToUpper() == answ)
                    {
                        correct = true;
                    }
                }
                if (!correct)
                {
                    Console.WriteLine("Mauvaise saisie");
                }
            } while (!correct);
            RésultatDeTir res = RésultatDeTir.Inconnu;
            if (answ == "TOUCHÉ")
            {
                res = RésultatDeTir.Touché;
            }
            if (answ == "TOUCHÉCOULÉ")
            {
                res = RésultatDeTir.TouchéCoulé;
            }
            if (answ == "TOUCHÉCOULÉFINAL")
            {
                res = RésultatDeTir.TouchéCouléFinal;
            }
            if (answ == "RATÉ")
            {
                res = RésultatDeTir.Raté;
            }
            return res;
        }

        public void Attaquant_GérerLeRésultatDuTir(CoordonnéesDeBatailleNavale coord, RésultatDeTir res)
        {
            Console.WriteLine($"Pour la case de coordonnées ({coord.Colonne},{coord.Ligne}) la réponse du défenseur est {Enum.GetName(typeof(RésultatDeTir), res)} ");
            Console.WriteLine("Changement de rôle ...");
            Console.WriteLine("");
        }
    }
}
