using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace MoteurDeBatailleNavale
{
    public class CarteDesTirs
    {
        private RésultatDeTir[,] _cases;

        public CarteDesTirs()
        {
            _cases = new RésultatDeTir[10, 10];

        }
        public void MarquerEmplacement(CoordonnéesDeBatailleNavale coord,RésultatDeTir res)
        {
            int colonne = coord.Colonne - 'A';
            int ligne = coord.Ligne - 1;
            _cases[colonne, ligne] = res;
        }

        public void MiseAZéro()
        {
            for (int pos = 0; pos < 10; pos++)
            {
                for (int i = 0; pos < 10; pos++)
                {
                    MarquerEmplacement(new CoordonnéesDeBatailleNavale(CoordonnéesDeBatailleNavale.colposs[pos], CoordonnéesDeBatailleNavale.ligneposs[i]), RésultatDeTir.Inconnu);
                }
            }
        }

        public RésultatDeTir VérifierEmplacement(CoordonnéesDeBatailleNavale coord)
        {
            int colonne = coord.Colonne - 'A';
            int ligne   = coord.Ligne - 1;
           
            /*foreach (char elt in CoordonnéesDeBatailleNavale.colposs)
            {
                if (elt == coord.Colonne)
                {
                    pos = ind;
                }
                ind++;
            }*/
            return _cases[colonne, ligne];
        }


        public void DessinerDansLaConsole()
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
                    switch (_cases[x, y])
                    {
                        case RésultatDeTir.Raté:
                            Write("{=Red}R{/}");
                            break;
                        case RésultatDeTir.Touché:
                            Write("{=Green}T{/}");
                            break;
                        case RésultatDeTir.TouchéCoulé:
                        case RésultatDeTir.TouchéCouléFinal:
                            Write("{=Blue}C{/}");
                            break;
                        default:
                            Console.Write(" ");
                            break;
                    }
                    Console.Write(" | ");
                }
                Console.WriteLine();
            }
            Console.WriteLine("--------------------------------------------");
        }

        public void DessinerDansLaConsoleFinal()
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
                    switch (_cases[x, y])
                    {
                        
                        case RésultatDeTir.Touché:
                        case RésultatDeTir.TouchéCoulé:
                        case RésultatDeTir.TouchéCouléFinal:
                            Console.Write("X");
                            break;
                        default:
                            Console.Write(" ");
                            break;
                    }
                    Console.Write(" | ");
                }
                Console.WriteLine();
            }
            Console.WriteLine("--------------------------------------------");
        }

        public void Write(string msg)
        {
            string[] ss = msg.Split('{', '}');
            ConsoleColor c;
            foreach (var s in ss)
                if (s.StartsWith("/"))
                    Console.ResetColor();
                else if (s.StartsWith("=") && Enum.TryParse(s.Substring(1), out c))
                    Console.ForegroundColor = c;
                else
                    Console.Write(s);
        }
    }
}
