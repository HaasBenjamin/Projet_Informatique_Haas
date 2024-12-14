using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace CastleModel
{
    public class BaseHeap:Pile
    {
        public override bool CanPop()
        {
            return false;
        }
        public override bool CanPush(Card c)
        {
            return this.Last.CanCover(c);
        }

        public override Move.Pile MovePile
        {
            get
            {
                Move.Pile pile = new Move.Pile();
                pile.Name = Move.PileName.BASEHEAP;
                pile.Number = this.Number;
                return pile;
            }
        }

        public BaseHeap(int number = 0)
        {
            this.Number = number;
            this.Name = "B";
        }

        public override string Encode()
        {
            StringBuilder repres = new StringBuilder("");
            if (!Empty)
            {
                repres.Append(Last.Encode());
            }
            return repres.ToString();
        }

        public override void Decode(string cartes)
        {
            
            if (cartes.Length != 1)
            {
                throw new ArgumentException("L’encodage ne doit contenir qu’un seul caractère");
            }
            this.cards.Clear();
            Card carte_dessus = Card.Decode(cartes[0]);
            int num = carte_dessus.Figure.Value;
            Card.Suit coul = carte_dessus.Color;
            int i = 1;
            while (i <= num)
            {
                this.cards.Add(new Card(i, coul, true));
                i++;
            }
        
        }

        public override string Save()
        {
            StringBuilder repres = new StringBuilder("");
            if (!Empty)
            {
                repres.Append(Last.Save());
            }
            return repres.ToString();
        }

        public override void Load(string cartes)
        {
            this.cards.Clear();
            if (cartes.Length == 2)
            {
                StringBuilder carte = new StringBuilder("");
                carte.Append(cartes[0]);
                carte.Append(cartes[1]);
                Card carte_dessus = Card.Load(carte.ToString());
                int num = carte_dessus.Figure.Value;
                Card.Suit coul = carte_dessus.Color;
                int i = 1;
                while (i <= num)
                {
                    this.cards.Add(new Card(i, coul, true));
                    i++;
                }
            }
        }

        public BaseHeap(BaseHeap bh) : base(bh)
        {
        }
    }
}
