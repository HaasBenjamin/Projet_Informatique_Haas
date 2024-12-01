using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace MoteurDeBatailleNavale
{
    public class UnJoueurRobotPasTropBête: UnJoueurAvecUneFlotteDeNavireEtUneCarteDeTirs
    {
        public UnJoueurRobotPasTropBête(string pseudo) : base(pseudo) { }
        private List<CoordonnéesDeBatailleNavale> list_coord = new List<CoordonnéesDeBatailleNavale>();
        private List<CoordonnéesDeBatailleNavale> list_coord_tmp = new List<CoordonnéesDeBatailleNavale>();
        public bool VérifierPrésence(CoordonnéesDeBatailleNavale coord,List<UnNavire> navires)
        {
            foreach (UnNavire navire in navires)
            {
                foreach (UneSectionDeNavire section in navire.Sections)
                {
                    if (section.Position.Colonne==coord.Colonne && section.Position.Ligne == coord.Ligne)
                    {
                        return false;
                    }
                }
            }
            return true;
        }

        public override void PréparerLaBataille()
        {
            byte ligne = 1;
            base.PréparerLaBataille();
            CoordonnéesDeBatailleNavale coord = new CoordonnéesDeBatailleNavale('A', 1);
            OrientationNavire orientation = OrientationNavire.Horizontal;
            bool coordposs = true;
            byte ligneact = 0;
            char colact = ' ';
            char colonne = ' ';
            byte ligneposs = 0;
            List<UnNavire> navires = new List<UnNavire>();
            foreach (UnNavire navire in Flotte.Navires)
            {
                coordposs = true;
                orientation=OrientationNavire.Horizontal;
                do
                {
                    Random rnd = new Random();
                    int randIndex = rnd.Next(1, 11);
                    ligneposs = (byte)randIndex;
                    randIndex = rnd.Next(10);
                    colonne = CoordonnéesDeBatailleNavale.colposs[randIndex];
                    coord = new CoordonnéesDeBatailleNavale(colonne, ligneposs);
                    if (rnd.Next(2) == 0)
                    {
                        orientation = OrientationNavire.Vertical;
                        coordposs = false;

                        if ((ligneposs + navire.Sections.Length) <= 11)
                        {
                            coordposs = true;
                            ligneact = ligneposs;
                            for (int i = 0; i < navire.Sections.Length; i++)
                            {

                                if (!VérifierPrésence(new CoordonnéesDeBatailleNavale(colonne, ligneact), navires))
                                {
                                    coordposs = false;
                                    break;
                                }
                                ligneact++;
                            }
                        }
                    }
                    else
                    {
                        coordposs = false;
                        if ((colonne + navire.Sections.Length) <= 'K')
                        {
                            coordposs = true;
                            colact = colonne;

                            for (int j = 0; j < navire.Sections.Length; j++)
                            {

                                if (!VérifierPrésence(new CoordonnéesDeBatailleNavale(colact, ligneposs), navires))
                                {
                                    coordposs = false;
                                    break;
                                }
                                colact++;
                            }
                        }
                    }
                } while (!coordposs);
                navire.Positionner(coord,orientation);
                navires.Add(navire);
            }
        }


        public override CoordonnéesDeBatailleNavale Attaquant_ChoisirLesCoordonnéesDeTir()
        {
            bool tire = false;
            CoordonnéesDeBatailleNavale coord = new CoordonnéesDeBatailleNavale('A', 1);
            byte ligne = 0;
            char colonne = ' ';
            if (list_coord.Count > 0)
            {
                if (CarteDesTirs.VérifierEmplacement(list_coord[0]) == RésultatDeTir.Raté)
                {
                    list_coord.RemoveAt(0);
                    if (list_coord.Count == 0 && list_coord_tmp.Count>0)
                    {
                        list_coord = list_coord_tmp;
                    }
                }
                else if (CarteDesTirs.VérifierEmplacement(coord) == RésultatDeTir.TouchéCoulé)
                {
                    list_coord.Clear();
                    list_coord_tmp.Clear();
                }
                else
                {
                    coord = list_coord[0];
                    list_coord.RemoveAt(0);
                    list_coord_tmp = list_coord;
                    list_coord.Clear();
                    if (!TirLigneLogique(coord) && !TirColonneLogique(coord))
                    {
                        if (coord.Ligne - 2 >= 0)
                        {
                            list_coord.Add(new CoordonnéesDeBatailleNavale(coord.Colonne, CoordonnéesDeBatailleNavale.ligneposs[coord.Ligne - 2]));
                        }
                        if (coord.Ligne <= 9)
                        {
                            list_coord.Add(new CoordonnéesDeBatailleNavale(coord.Colonne, CoordonnéesDeBatailleNavale.ligneposs[coord.Ligne]));
                        }
                        if (coord.Colonne - 1 - 'A' >= 0)
                        {
                            list_coord.Add(new CoordonnéesDeBatailleNavale(CoordonnéesDeBatailleNavale.colposs[coord.Colonne - 1 - 'A'], coord.Ligne));
                        }
                        if (coord.Colonne + 1 - 'A' <= 9)
                        {
                            list_coord.Add(new CoordonnéesDeBatailleNavale(CoordonnéesDeBatailleNavale.colposs[coord.Colonne + 1 - 'A'], coord.Ligne));
                        }
                        
                    }

                }
            }
            do
            {
                if (list_coord.Count == 0)
                {
                    Random rnd = new Random();
                    int randIndex = rnd.Next(10);
                    ligne = CoordonnéesDeBatailleNavale.ligneposs[randIndex];
                    randIndex = rnd.Next(10);
                    colonne = CoordonnéesDeBatailleNavale.colposs[randIndex];
                    coord= new CoordonnéesDeBatailleNavale(colonne, ligne);
                    if (CarteDesTirs.VérifierEmplacement(coord) == RésultatDeTir.Inconnu)
                    {
                        tire = true;
                        list_coord.Add(coord);
                    }
                }
                else
                {
                    coord = list_coord[0];
                    if (CarteDesTirs.VérifierEmplacement(coord) == RésultatDeTir.Inconnu)
                    {
                        tire = true;
                    }
                    else
                    {
                        list_coord.RemoveAt(0);
                    }
                }
                
            }while(!tire);
            Console.WriteLine($"Coordonnée choisie par le robot = ({colonne},{ligne})");
            return coord;  
        }

        public void DessinerDansLaConsoleBateaux()
        {
            Console.WriteLine("--------------------------------------------");
            Console.Write("    | ");
            for (int x = 0; x < 10; x++)
            {
                Console.Write((char)('A' + x));
                Console.Write(" | ");
            }
            Console.WriteLine();
            for (byte y = 0; y < 10; y++)
            {
                Console.WriteLine("--------------------------------------------");
                Console.Write(" " + (y + 1).ToString("00") + " | ");
                for (int x = 0; x < 10; x++)
                {
                    string caractere = " ";
                    foreach (UnNavire navire in Flotte.Navires)
                    {
                        int position = 1;
                        foreach (UneSectionDeNavire section in navire.Sections)
                        {
                            int taille = navire.Sections.Length;
                            if ((section.Position.Colonne - 'A') == x && (section.Position.Ligne - 1) == y)
                            {
                                caractere = " ";
                                if (position == 1)
                                {
                                    if (navire.Orientation == OrientationNavire.Horizontal)
                                    {
                                        caractere = "<";
                                    }
                                    else
                                    {
                                        caractere = "^";
                                    }
                                }
                                else if (position == taille)
                                {

                                    if (navire.Orientation == OrientationNavire.Horizontal)
                                    {
                                        caractere = ">";
                                    }
                                    else
                                    {
                                        caractere = "v";
                                    }
                                }
                                else
                                {
                                    if (navire.Orientation == OrientationNavire.Horizontal)
                                    {
                                        caractere = "=";
                                    }
                                    else
                                    {
                                        caractere = "H";
                                    }
                                }
                            }
                            position++;
                        }
                    }
                    Console.Write(caractere);
                    Console.Write(" | ");
                }
                Console.WriteLine();
            }
            Console.WriteLine("--------------------------------------------");



        }
        public bool TirLigneLogique(CoordonnéesDeBatailleNavale coord)
        {
            List<CoordonnéesDeBatailleNavale> list_poss = new List<CoordonnéesDeBatailleNavale>();
            int i = 1;
            bool logique_poss = true;
            int total_ligne = 1;
            do
            {
                if (coord.Ligne + i <= 10)
                {

                    CoordonnéesDeBatailleNavale coord_act = new CoordonnéesDeBatailleNavale(coord.Colonne, CoordonnéesDeBatailleNavale.ligneposs[coord.Ligne + i - 1]); //A droite 
                    if (CarteDesTirs.VérifierEmplacement(coord_act) == RésultatDeTir.Inconnu && total_ligne > 1)
                    {
                        list_poss.Add(coord_act);
                        break;
                    }
                    else if (CarteDesTirs.VérifierEmplacement(coord_act) == RésultatDeTir.Touché)
                    {
                        total_ligne++;
                    }
                    else if (CarteDesTirs.VérifierEmplacement(coord_act) == RésultatDeTir.Raté || CarteDesTirs.VérifierEmplacement(coord_act) == RésultatDeTir.Inconnu)
                    {
                        logique_poss = false;
                    }
                    i++;
                }
                else
                {
                    logique_poss = false;
                }
            } while (logique_poss);
            i = 1;
            logique_poss = true;
            do
            {
                if (coord.Ligne - i >= 1)
                {
                    CoordonnéesDeBatailleNavale coord_act = new CoordonnéesDeBatailleNavale(coord.Colonne, CoordonnéesDeBatailleNavale.ligneposs[coord.Ligne - i - 1]); //A gauche 
                    if (CarteDesTirs.VérifierEmplacement(coord_act) == RésultatDeTir.Inconnu && total_ligne > 1)
                    {
                        list_poss.Add(coord_act);
                        break;
                    }
                    else if (CarteDesTirs.VérifierEmplacement(coord_act) == RésultatDeTir.Touché)
                    {
                        total_ligne++;
                    }
                    else if (CarteDesTirs.VérifierEmplacement(coord_act) == RésultatDeTir.Raté || CarteDesTirs.VérifierEmplacement(coord_act)==RésultatDeTir.Inconnu)
                    {
                        logique_poss = false;
                    }
                    i++;
                }
                else
                {
                    logique_poss=false;
                }
            } while (logique_poss);
            if (list_poss.Count > 0)
            {
                foreach(CoordonnéesDeBatailleNavale coord_act in list_poss)
                {
                    list_coord.Add(coord_act);
                }
                return true;
            }
            return false;
        }

        public bool TirColonneLogique(CoordonnéesDeBatailleNavale coord)
        {
            List<CoordonnéesDeBatailleNavale> list_poss = new List<CoordonnéesDeBatailleNavale>();
            int i = 1;
            bool logique_poss = true;
            int total_ligne = 1;
            do
            {
                if (coord.Colonne + i -'A'<= 9)
                {

                    CoordonnéesDeBatailleNavale coord_act = new CoordonnéesDeBatailleNavale(CoordonnéesDeBatailleNavale.colposs[coord.Colonne + i - 'A'], coord.Ligne ); //En Bas
                    if (CarteDesTirs.VérifierEmplacement(coord_act) == RésultatDeTir.Inconnu && total_ligne > 1)
                    {
                        list_poss.Add(coord_act);
                        break;
                    }
                    else if (CarteDesTirs.VérifierEmplacement(coord_act) == RésultatDeTir.Touché)
                    {
                        total_ligne++;
                    }
                    else if (CarteDesTirs.VérifierEmplacement(coord_act) == RésultatDeTir.Raté || CarteDesTirs.VérifierEmplacement(coord_act) == RésultatDeTir.Inconnu)
                    {
                        logique_poss = false;
                    }
                    i++;
                }
                else
                {
                    logique_poss = false;
                }
            } while (logique_poss);
            i = 1;
            logique_poss = true;
            do
            {
                if (coord.Colonne - i - 'A' >= 0)
                {
                    CoordonnéesDeBatailleNavale coord_act = new CoordonnéesDeBatailleNavale(CoordonnéesDeBatailleNavale.colposs[coord.Colonne - i - 'A'], coord.Ligne ); //En Haut
                    if (CarteDesTirs.VérifierEmplacement(coord_act) == RésultatDeTir.Inconnu && total_ligne > 1)
                    {
                        list_poss.Add(coord_act);
                        break;
                    }
                    else if (CarteDesTirs.VérifierEmplacement(coord_act) == RésultatDeTir.Touché)
                    {
                        total_ligne++;
                    }
                    else if (CarteDesTirs.VérifierEmplacement(coord_act) == RésultatDeTir.Raté || CarteDesTirs.VérifierEmplacement(coord_act) == RésultatDeTir.Inconnu)
                    {
                        logique_poss = false;
                    }
                    i++;
                }
                else
                {
                    logique_poss = false;
                }
            } while (logique_poss);
            if (list_poss.Count > 0)
            {
                foreach (CoordonnéesDeBatailleNavale coord_act in list_poss)
                {
                    list_coord.Add(coord_act);
                }
                return true;
            }
            return false;
        }
    }
}





