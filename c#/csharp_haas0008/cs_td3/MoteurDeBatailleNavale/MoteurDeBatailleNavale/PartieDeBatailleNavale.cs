using System;
using System.Collections;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace MoteurDeBatailleNavale
{
    public class PartieDeBatailleNavale
    {
        public IContratDuJoueurDeBatailleNavale Attaquant
        {
            get;
            private set;
        }

        public IContratDuJoueurDeBatailleNavale Défenseur
        {
            get;
            private set;
        }
        public PartieDeBatailleNavale(IContratDuJoueurDeBatailleNavale joueur1, IContratDuJoueurDeBatailleNavale joueur2)
        {
            if (joueur1 == null || joueur2 == null)
            {
                throw new ArgumentNullException("L'un des joueurs est null");
            }
            this.Défenseur = joueur1;
            this.Attaquant = joueur2;

        }

        

        public void IntervertirLesRôlesDesJoueurs()
        {
            IContratDuJoueurDeBatailleNavale att = this.Attaquant;
            this.Attaquant = this.Défenseur;
            this.Défenseur = att;
        }

        public void ChoisirLesRôlesDeDépartDesJoueurs()
        {
            var rand = new Random();
            if (rand.Next(2) == 0)
            {
                IntervertirLesRôlesDesJoueurs();
            }

        }

        public void PréparerLaBataille()
        {
            this.Défenseur.PréparerLaBataille();
            this.Attaquant.PréparerLaBataille();
        }

        public void JouerLaPartie()
        {
            int nbTirs = 0;
            RésultatDeTir res = RésultatDeTir.Inconnu;
            do
            {
                CoordonnéesDeBatailleNavale coord = this.Attaquant.Attaquant_ChoisirLesCoordonnéesDeTir();
                res = this.Défenseur.Défenseur_FournirLeRésultatDuTir(coord);
                this.Attaquant.Attaquant_GérerLeRésultatDuTir(coord, res);
                if (res != RésultatDeTir.TouchéCouléFinal)
                {
                    IntervertirLesRôlesDesJoueurs();

                }
                nbTirs++;
            } while (res != RésultatDeTir.TouchéCouléFinal);


            Console.WriteLine($"Félicitations {this.Attaquant.Pseudo} !!! ");
            GestionnaireDesScores gest = new GestionnaireDesScores();
            gest.EnregistrerUnNouveauScore( new Score(this.Attaquant.Pseudo,this.Défenseur.Pseudo,nbTirs));
        }

    }
}
