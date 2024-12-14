using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace CastleModel
{
    public class Heap:Pile
    {
        public override bool CanPush(Card c)
        {
            return true;
        }
        public override Move.Pile MovePile
        {
            get
            {
                Move.Pile pile = new Move.Pile();
                pile.Name = Move.PileName.HEAP;
                pile.Number = this.Number;
                return pile;

            }
        }

        public override Card? CardToMove
        {
            get
            {
                return Last;
            }
        }
        public Heap(int number=0)
        {
            this.Number = number;
            this.Name = "H";
        }


        public override void ApplyMove(Castle castle, Move move)
        {
            move.CardsCount = 1;
            Pile pile = castle.GetPile(move.From);
            if (pile.Empty)
            {
                throw new ArgumentException($"La pile source {move.From.Name}{move.From.Number} est vide !");
            }
            /*

            if (move.To == null)
            {
                Pile dest = castle.SearchPileForCard(pile.Last);
                if (dest != null)
                {
                    Move.Pile topile = new Move.Pile();
                    topile.Number = dest.Number;
                    Move.PileName pilename = Move.PileName.BASEHEAP;
                    if (dest.Name == "C")
                    {
                        pilename = Move.PileName.COLUMN;
                    }

                    topile.Name = pilename;
                    move.To = topile;
                    
                }


            } */
            if (move.To != null)
            {

            
            if (move.To.Name == Move.PileName.BASEHEAP)
            {
                int? basenum = castle.GetBaseHeapFor(Last);
                if (null == basenum)
                {
                    throw new ArgumentException($"Aucun déplacement possible depuis le tas de distribution {move.From.Name}{move.From.Number} vers une pile de base");
                }
                else
                {
                    Move.Pile basepile = new Move.Pile();
                    basepile.Number = basenum.Value;
                    basepile.Name = Move.PileName.BASEHEAP;
                    Pile baseHeap = castle.GetPile(basepile);
                    move.To.Number = baseHeap.Number;
                    baseHeap.Push(this.Pop());

                }
            }
            else if (move.To.Name == Move.PileName.COLUMN)
            {
                Pile? colonne = castle.GetPile(move.To);
                if (null == colonne)
                {
                    throw new ArgumentException($"Aucun déplacement possible depuis le tas de distribution {move.From.Name}{move.From.Number} vers une colonne");
                }
                else
                {
                    move.To.Number = colonne.Number;
                    colonne.Push(this.Pop());

                }
            }
            else if (move.To.Name == Move.PileName.HEAP)
            {
               throw new ArgumentException($"Aucun déplacement possible depuis le tas de distribution vers un tas de distribution");

            }
           }

        }

        public  void ApplyMoveIfPoss(Castle castle, Move move)
        {
            move.CardsCount = 1;
            Pile pile = castle.GetPile(move.From);
            if (pile.Empty)
            {
                throw new ArgumentException($"La pile source {move.From.Name}{move.From.Number} est vide !");
            }

            if (move.To == null)
            {
                Pile dest = castle.SearchPileForCard(pile.Last);
                if (dest != null)
                {
                    Move.Pile topile = new Move.Pile();
                    topile.Number = dest.Number;
                    Move.PileName pilename = Move.PileName.BASEHEAP;
                    if (dest.Name == "C")
                    {
                        pilename = Move.PileName.COLUMN;
                    }

                    topile.Name = pilename;
                    move.To = topile;

                }


            }
            if (move.To != null)
            {


                if (move.To.Name == Move.PileName.BASEHEAP)
                {
                    int? basenum = castle.GetBaseHeapFor(Last);
                    if (null == basenum)
                    {
                        throw new ArgumentException($"Aucun déplacement possible depuis le tas de distribution {move.From.Name}{move.From.Number} vers une pile de base");
                    }
                    else
                    {
                        Move.Pile basepile = new Move.Pile();
                        basepile.Number = basenum.Value;
                        basepile.Name = Move.PileName.BASEHEAP;
                        Pile baseHeap = castle.GetPile(basepile);
                        move.To.Number = baseHeap.Number;
                        baseHeap.Push(this.Pop());

                    }
                }
                else if (move.To.Name == Move.PileName.COLUMN)
                {
                    int? colnum = castle.GetColumnFor(Last, true);
                    if (null == colnum)
                    {
                        throw new ArgumentException($"Aucun déplacement possible depuis le tas de distribution {move.From.Name}{move.From.Number} vers une colonne");
                    }
                    else
                    {
                        Move.Pile colpile = new Move.Pile();
                        colpile.Number = colnum;
                        colpile.Name = Move.PileName.COLUMN;
                        Pile colonne = castle.GetPile(colpile);
                        move.To.Number = colonne.Number;
                        colonne.Push(this.Pop());

                    }
                }
                else if (move.To.Name == Move.PileName.HEAP)
                {
                    throw new ArgumentException($"Aucun déplacement possible depuis le tas de distribution vers un tas de distribution");

                }
            }

        }



        public Heap(Heap heap) : base(heap) { }
    }
}
