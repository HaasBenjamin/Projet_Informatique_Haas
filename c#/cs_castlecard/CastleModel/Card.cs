using System.Text;

namespace CastleModel
{
    
    public class Card
    {
        #region suit
        public enum Suit : byte
        {
            CLUB = 1,
            SPADE,
            HEART,
            DIAMOND

        }
        #endregion
        #region face
        public class Face
        {
            private List<string> acceptedValues = new List<string> { "A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K" };
            private int value;

            public int Value { get { return value; } }

            public override bool Equals(object? obj)
            {
                if (obj is Face f)
                {
                    return f.GetHashCode() == value;
                }
                return false;
            }

            public Face(int value)
            {
                if (value < 1 || value > 13)
                {
                    throw new ArgumentOutOfRangeException($"La valeur {value} n'est pas acceptée pour une figure");
                }
                this.value = value;
            }

            public Face(string value)
            {
                int tmp = this.acceptedValues.IndexOf(value) + 1;
                if (tmp == 0)
                {
                    if (value == "1")
                    {
                        this.value = 1;
                    }

                    else
                    {
                        throw new ArgumentOutOfRangeException($"La valeur {value} n'est pas acceptée pour une figure");
                    }
                }
                else
                {
                    this.value = tmp;
                }

            }

            public override string ToString()
            {
                return acceptedValues[value - 1];
            }

            public override int GetHashCode()
            {
                return value;
            }

        }
        #endregion 
        public Suit Color { get; set; }
        public Face Figure { get; set; }

        public bool Visible { get; set; }

        public Card(Face face,Suit color,bool visible)
        {
            this.Visible = visible;
            this.Figure = face;
            this.Color = color;
        }

        public Card(int face,Suit color,bool visible)
        {
            this.Visible=visible;
            this.Color=color;
            this.Figure = new Face(face);
        }

        public override int GetHashCode()
        {
            return ((this.Figure.Value - 1) * 4 + (int)this.Color);
        }

        public override bool Equals(object? obj)
        {
            if (obj is Card c)
            {
                return this.Color == c.Color && this.Figure.Value == c.Figure.Value;
            }
            return false;
        }
        public override string ToString()
        {
            string visibilité;
            if (this.Visible)
            {
                visibilité = "visible";
            }
            else
            {
                visibilité = "cachée";
            }
            return this.Figure.ToString()+$". La carte porte la couleur {this.Color}. "+$"La carte est actuellement {visibilité}";
        }

        public bool CanCover(Card carte)
        {
            bool retour = false;
            if (carte is null)
            {
                retour = true;
            }
            else
            {
                if (this.Color == carte.Color)
                {
                    if (this.Figure.Value +1 == carte.Figure.Value )
                    {
                        retour = true;
                    }
                }
            }
            
            return retour;
        }

        public char Encode()
        {
            return (char)(' ' + (this.Figure.Value - 1) * 4 + (int)this.Color);
        }

        public static Card Decode(char caractere)
        {
            Card carte = new Card(new Face(5), Suit.CLUB, true);
            int tmp =(caractere - ' ') - 1;
            int modulo = (tmp % 4);
            if (modulo == 3)
            {
                carte.Color = Suit.DIAMOND;
                carte.Figure = new Face(((tmp - 3) / 4)+1);
            }
            else if (modulo == 0)
            {
                carte.Color = Suit.CLUB;
                carte.Figure = new Face(((tmp) / 4) + 1);
            }
            else if (modulo == 1)
            {
                carte.Color = Suit.SPADE;
                carte.Figure = new Face(((tmp - 1) / 4) + 1);
            }
            else if (modulo == 2)
            {
                carte.Color = Suit.HEART;
                carte.Figure = new Face(((tmp - 2) / 4) + 1);
            }
            return carte;

        }

        public string Save()
        {
            string fig = this.Figure.ToString();
            if (fig == "10")
            {
                fig = "0";
            }
            return  fig + this.Color.ToString()[0];
        }

        public static Card Load(string carte)
        {
            StringBuilder fig = new StringBuilder("");
            fig.Append(carte[0]);
            Face carteFace= new Face(fig.ToString());
            if (carte[0] == '0')
            {
                carteFace = new Face("10");
            }
            Suit col = Suit.CLUB;
            switch (carte[1])
            {
                case 'H':
                    col = Suit.HEART;
                    break;
                case 'S': 
                    col = Suit.SPADE;
                    break;
                case 'D':
                    col = Suit.DIAMOND;
                    break;
                case 'C':
                    col = Suit.CLUB;
                    break;
            }

            return new Card(carteFace, col,true);
            
        }

        public Card(Card c)
        {
            this.Figure = c.Figure;
            this.Color = c.Color;
            this.Visible = c.Visible;
        }
    }
}