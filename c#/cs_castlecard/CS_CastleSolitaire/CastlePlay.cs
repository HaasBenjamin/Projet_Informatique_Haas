using CastleModel;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ConsoleCastle
{
    public class CastlePlay
    {
        private Castle castle;
        private ConsoleCard console;

        public CastlePlay(int nline = -1, int ncolumn = 80)
        {
           console = new ConsoleCard(nline,ncolumn);
           castle = new Castle();
        }

        public void Play()
        {
            castle.Distribute();
            string? depl = "";
            do
            {
                console.Clear();
                Console.Clear();
                console.Print(castle);
                console.Refresh();
                Move? dep = castle.SearchMoveToBaseHeap();
                if (dep is not null)
                {
                    Thread.Sleep(1000); // Attente d’une seconde, adaptez le temps d’attente si nécessaire…
                    castle.ApplyMove(dep);
                }
                else
                {
                    int? deplnum = null;
                    Pile from= null;
                    /*
                    foreach (Heap heap in castle.Heaps)
                    {
                        if (!heap.Empty)
                        {
                            deplnum = castle.GetColumnFor(heap.Last, false);
                            if (deplnum is not null)
                            {
                                from=heap;
                                break;
                            }
                        }
                    }
                    if (deplnum is null)
                    {

                        foreach (Column column in castle.Column)
                        {
                            if (!column.Empty)
                            {

                                deplnum = castle.GetColumnFor(column.First, false);
                                if (deplnum is not null)
                                {
                                    from = column;
                                    break;
                                }

                            }
                        }
                    }*/
                    if (deplnum is not null)
                    {
                        Move.Pile to = new Move.Pile();
                        to.Number = deplnum;
                        to.Name = Move.PileName.COLUMN;
                        Move mv = new Move(from, castle.GetPile(to));
                        castle.ApplyMove(mv);
                        Console.WriteLine("Déplacement automatique");
                        Thread.Sleep(500);
                    }
                    else
                    {
                        Console.WriteLine("Déplacements :\n- " + string.Join("\n- ", castle.SearchAllMoves()));

                        Console.WriteLine("Veuillez saisir un déplacement ou Stop pour arrêter");
                        depl = (Console.ReadLine() ?? "S").ToUpper();
                        if (null != depl && !(depl.StartsWith("S")) && !(depl.StartsWith("L")))
                        {
                            if (depl.StartsWith("U"))
                            {
                                castle.UndoMove();
                            }
                            else
                            {
                                try
                                {
                                    castle.ApplyMove(new Move(depl, castle));
                                }
                                catch (ArgumentException arg)
                                {
                                    Console.WriteLine(arg.Message);
                                    Console.ReadKey();
                                }
                            }
                        }
                        else if (null != depl && (depl.StartsWith("SAVE")))
                        {
                            castle.Save(depl.Substring(4));
                            Console.WriteLine("Sauvegarde effectuée");
                            Console.ReadKey();
                        }
                        else if (null != depl && (depl.StartsWith("LOAD")))
                        {
                            castle.Load(depl.Substring(4));
                            console.Clear();
                            Console.Clear();
                            console.Print(castle);
                            console.Refresh();
                            Console.WriteLine("Chargement effectuée");
                            Console.ReadKey();
                        }
                        
                    }

                }

            } while (null != depl && !(depl.StartsWith("STOP")) && !castle.Finished);
            console.Clear();
            console.Print(castle);
            console.Refresh();
        }
    }
}
