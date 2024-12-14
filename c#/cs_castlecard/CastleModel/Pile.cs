using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace CastleModel
{
    public abstract class Pile
    {
        #region Pile
        protected List<Card>? cards = new List<Card>();

        public int Count
        {
            get { return cards.Count; }
        }
        public bool Empty
        {
            get { return cards.Count == 0; }
        }

        public string Name
        {
            get; set;
        }
        public Card? Last {
            get
            {
                if (Empty)
                {
                    return null;
                }
                else
                {
                    return cards[cards.Count - 1];
                }
            }
        }
        public int Number { get; set; }
        public void Push(Card c)
        {
            cards.Add(c);
        }

        public void Clear()
        {
            cards.Clear();
        }

        public virtual Card? CardToMove
        {
            get {
                return null;
            }
        }

        public abstract bool CanPush(Card c);

        public virtual bool CanPop()
        {
            return !Empty;
        }

        public abstract Move.Pile MovePile { get; }

        public Card Pop()
        {
            if (!CanPop())
            {
                throw new InvalidOperationException("Impossible de supprimer une carte");
            }
            Card carte = cards[cards.Count - 1];
            cards.RemoveAt(cards.Count - 1);
            return carte;
        }
        public override string ToString()
        {
            return $"Pile : {Name} N° {Number}";
        }

        public IEnumerator<Card> GetEnumerator()
        {
            return cards.GetEnumerator();
        }

        public virtual void ApplyMove(Castle castle, Move move)
        {
            throw new ArgumentException($"Un déplacement depuis la pile {move.From.Name} n’est pas autorisé");
        }

        public virtual void UndoMove(Pile? to, int cardsCount)
        {
            if (to != null)
            {
                this.Push(to.Pop());
            }
            
        }

        public virtual string Encode()
        {
            StringBuilder repres = new StringBuilder("");
            foreach (Card carte in this.cards)
            {
                repres.Append(carte.Encode());   
            }
            return repres.ToString();
        }

        public virtual void Decode(string cartes)
        {
            this.cards.Clear();
            foreach (Char carte in cartes)
            {
                this.cards.Add(Card.Decode(carte));
            }
        }

        public virtual string Save()
        {
            StringBuilder repres = new StringBuilder("");
            foreach (Card carte in this.cards)
            {
                repres.Append(carte.Save());
            }
            return repres.ToString();
        }

        public virtual void Load(string cartes)
        {
            this.cards.Clear();
            int comp = 0;
            while (comp < cartes.Length)
            {
                StringBuilder carte = new StringBuilder("");
                carte.Append(cartes[comp]);
                carte.Append(cartes[comp+1]);
                this.cards.Add(Card.Load(carte.ToString()));
                comp=comp + 2;
            }
        }

        public Pile(Pile p)
        {
            this.Name = p.Name;
            this.Number = p.Number;
            this.cards = new List<Card>();
            foreach(Card carte in p.cards)
            {
                this.cards.Add(new Card(carte));
            }
        }

        public Pile()
        {
            this.Number  = 0;
        }
        #endregion
    }
}
