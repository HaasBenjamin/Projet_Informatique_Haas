using System;
using System.Collections.Generic;
using System.Linq;
using System.Linq.Expressions;
using System.Text;
using System.Threading.Tasks;

namespace MoteurDeBatailleNavale
{
    public class UnJoueurHumain: UnJoueurAvecUneFlotteDeNavireEtUneCarteDeTirs
    {
        public UnJoueurHumain(string pseudo) : base(pseudo) { }

        public bool VérifierPrésence(CoordonnéesDeBatailleNavale coord,List<UnNavire>navires)
        {
            foreach (UnNavire navire in navires)
            {
                foreach (UneSectionDeNavire section in navire.Sections)
                {
                    if (section.Position.Colonne == coord.Colonne && section.Position.Ligne == coord.Ligne)
                    {
                        throw new Exception("Position déjà utilisée");
                    }
                }
            }
            return true;
        }

        public bool IsPossible(CoordonnéesDeBatailleNavale coord,OrientationNavire orientation,UnNavire navire,List<UnNavire>navires)
        {
            byte ligne=coord.Ligne;
            char colonne = coord.Colonne;   
            if (orientation == OrientationNavire.Vertical)
            {

                if ((ligne + navire.Sections.Length) <= 11)
                {
                    for (int i = 0; i < navire.Sections.Length; i++)
                    {

                        VérifierPrésence(new CoordonnéesDeBatailleNavale(colonne, ligne),navires);
                        ligne++;

                    }
                    return true;
                }
            }
            else
            {
                if ((colonne + navire.Sections.Length) <= 'K')
                {
                    for (int j = 0; j < navire.Sections.Length; j++)
                    {

                        VérifierPrésence(new CoordonnéesDeBatailleNavale(colonne, ligne),navires);
                        colonne++;
                    }
                    return true;
                }
            }
            throw new Exception("Impossible de placer le bateau ici...");

           
        }
        public override void PréparerLaBataille()
        {

            base.PréparerLaBataille();
            char coldepart = 'A';
            byte lignedepart = 1;
            string depart = "";
            bool orientat = false;
            bool placement = false;
            List<UnNavire> list_navire_places= new List<UnNavire>();
            OrientationNavire orientation = OrientationNavire.Horizontal;
            CoordonnéesDeBatailleNavale coorddepart = new CoordonnéesDeBatailleNavale('A', 1);
            foreach (UnNavire navire in Flotte.Navires)
            {
                DessinerDansLaConsoleBateauxPlaces(list_navire_places);
                placement = false;
                orientat = false;
                do
                {
                    Console.WriteLine($"Placement du navire : {navire.Nom} possédant {navire.Sections.Length} sections");
                    Console.Write("Choississez une emplacement de départ : ");
                    depart = Console.ReadLine() ?? "";
                    coldepart = char.Parse(depart.Substring(0, 1).ToUpper());
                    lignedepart = byte.Parse(depart.Substring(1));
                    Console.Write("Choississez une orientation parmis : horizontal/vertical ");
                    do
                    {
                        string orientsaisie = (Console.ReadLine() ?? "").ToUpper();
                        if (orientsaisie == "HORIZONTAL" || orientsaisie == "HORIZONTAL ")
                        {
                            orientat = true;
                            orientation = OrientationNavire.Horizontal;
                        }
                        if (orientsaisie == "VERTICAL" || orientsaisie == "VERTICAL ")
                        {
                            orientat = true;
                            orientation = OrientationNavire.Vertical;
                        }

                    } while (!orientat);
                    coorddepart = new CoordonnéesDeBatailleNavale(coldepart, lignedepart);
                    try
                    {
                        IsPossible(coorddepart, orientation, navire,list_navire_places);
                        navire.Positionner(coorddepart, orientation);
                        list_navire_places.Add(navire);
                        placement = true;

                    }
                    catch (Exception ex)
                    {
                        Console.WriteLine("Placement impossible");
                    }
                } while (!placement);
                
            }
            Console.WriteLine("Placement final du joueur humain");
            DessinerDansLaConsoleBateaux();
        }
        

        public  CoordonnéesDeBatailleNavale Attaquant_ChoisirLesCoordonnéesDeTir_1()
        {
            char[] colposs = CoordonnéesDeBatailleNavale.colposs;
            byte[] ligneposs = CoordonnéesDeBatailleNavale.ligneposs;
            bool correct = false;
            char colonne = ' ';
            byte ligne = 0;
            bool possible = false;
            CoordonnéesDeBatailleNavale coord ;
            do
            {
                do
                {
                    ligne = 0;
                    Console.WriteLine($"{this.Pseudo}, entrez une case : ");
                    string rep = Console.ReadLine() ?? "";
                    string col = rep.Substring(0, 1);
                    col = col.ToUpper();
                    string lig = rep.Substring(1);
                    colonne = char.Parse(col);
                    byte.TryParse(lig, out ligne);
                    try
                    {
                        coord = new CoordonnéesDeBatailleNavale(colonne, ligne);
                        correct = true;
                    }catch(Exception ex)
                    {
                        Console.WriteLine("Mauvaise saisie");
                    }

                } while (!correct);

                coord = new CoordonnéesDeBatailleNavale(colonne, ligne);
                if (CarteDesTirs.VérifierEmplacement(coord) == RésultatDeTir.Inconnu)
                {
                    possible = true;
                }
                else
                {
                    Console.WriteLine("Coordonnée déjà choisie");
                }
            }while(!possible);
            return coord;
        }

        public override CoordonnéesDeBatailleNavale Attaquant_ChoisirLesCoordonnéesDeTir()
        {
            Console.WriteLine("Carte de tirs sur le joueur robot");
            //CarteDesTirs.DessinerDansLaConsole();
            return Attaquant_ChoisirLesCoordonnéesDeTir_1();
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


        


        public void DessinerDansLaConsoleBateauxPlaces(List<UnNavire> navires)
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
                    
                    foreach (UnNavire navire in navires)
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
                                else if (position == taille) {
                                
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

        




    }
}
