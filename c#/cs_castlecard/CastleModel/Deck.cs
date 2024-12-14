using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace CastleModel
{
    public class Deck:Pile
    {
        private List<Heap> heaps;
        public override bool CanPush(Card c)
        {
            return false;
        }

        public override bool CanPop()
        {
            return true;
        }

        public override Move.Pile MovePile
        {
            get
            {
                Move.Pile pile = new Move.Pile();
                pile.Name = Move.PileName.DECK;
                pile.Number = this.Number;
                return pile;

            }
        }

        public Deck(params Heap[] heaps)
        {
            this.Number = 1;
            this.Name = "D";
            List<Heap> heapstmp = new List<Heap>();
            for (int i = 0; i < heaps.Length; i++)
            {
                heapstmp.Add(heaps[i]);
            }
            this.heaps = heapstmp;
        }

        public bool canDistribute()
        {
            return Count>=3;
        }

        public void Distribute()
        {
            if (this.canDistribute())
            {
                foreach (Heap heap in this.heaps)
                {
                    Card carte = this.Pop();
                    carte.Visible = true;
                    heap.Push(carte);
                }
            }
            
        }

        public override void ApplyMove(Castle castle, Move move)
        {
            move.CardsCount = 3;
            Distribute();
        }

        public override void UndoMove(Pile? to, int cardsCount)
        {
            foreach(Heap heap in this.heaps)
            {
                Card carte = heap.Pop();
                carte.Visible = false;
                this.Push(carte);
            }
        }

        public override void Decode(string cartes)
        {
            base.Decode(cartes);
            foreach (Card carte in this.cards)
            {
                carte.Visible = false;
            }
        }

        public Deck(Deck d, params Heap[] he) 
        {
            this.Name = d.Name;
            this.Number = d.Number;
            this.cards = new List<Card>();
            foreach (Card carte in d.cards)
            {
                this.cards.Add(new Card(carte));
            }
            this.heaps = new List<Heap>();
            foreach (Heap heap in he)
            {
                this.heaps.Add(heap);
            }
        }
    }
}
