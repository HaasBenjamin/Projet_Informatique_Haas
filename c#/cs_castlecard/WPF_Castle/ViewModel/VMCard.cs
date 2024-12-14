using CastleModel;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace WPF_Castle.ViewModel
{
    public class VMCard
    {
        private Card card;
        private string imageName;

        public Card Card { get { return card; } }
        public string ImageName { get {  return imageName; } }

        public VMCard(Card carte) 
        {
            card = carte;
            imageName = ((card.Figure.Value == 1 ? 0 : (14 - card.Figure.Value) * 4) + (int)card.Color).ToString() + ".png";
        }

        public bool Hidden { get
            {
                return !this.card.Visible;
            }
        }

        public override string ToString()
        {
            return card.ToString();
        }
    }
}
