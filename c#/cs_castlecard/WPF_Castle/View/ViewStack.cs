using CastleModel;
using System;
using System.Collections.Generic;
using System.Data.Common;
using System.Diagnostics;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Documents;
using System.Windows.Media;
using System.Windows.Shapes;
using WPF_Castle.ViewModel;

namespace WPF_Castle.View
{
    public class ViewStack
    {
        private ViewCanvas canvas;
        private VMStack stack;
        private List<ViewCard> cards;
        private Rectangle rectangle;



        public bool IsStackSpread { get; set; } = true;
        public double CoverPercent { get; } = 0.75;

        public double X { get; set; } = 0.0;
        public double Y { get; set; } = 0.0;

        public int Count { get {  return cards.Count; } }

        public VMStack Stack { get { return stack; } }

        public ViewStack(ViewCanvas canvas, VMStack stack)
        {
            this.canvas = canvas;
            this.stack = stack;
            Rectangle rectangle = new Rectangle();
            rectangle.Width = ViewCard.InitialWidth;
            rectangle.Height = ViewCard.InitialHeight;
            rectangle.RadiusX = 5;
            rectangle.RadiusY = 5;
            rectangle.AllowDrop = true;
            rectangle.Fill = App.Current.Resources["backgroundColor"] as SolidColorBrush;
            rectangle.Drop += Rectangle_Drop;
            Canvas.SetZIndex(rectangle, 1);
            rectangle.Stroke = Brushes.MidnightBlue;
            rectangle.StrokeThickness = 2;
            this.rectangle = rectangle;
            this.cards = new List<ViewCard>();
        }

        private void Rectangle_Drop(object sender, System.Windows.DragEventArgs e)
        {
            if (e.Data.GetDataPresent(typeof(ViewCard)))
                if (e.Data.GetDataPresent(typeof(ViewCard)))
                {
                    ViewCard card = (ViewCard)e.Data.GetData(typeof(ViewCard));
                    if (this.Drop(card))
                    {
                        e.Handled = true;
                    }
                    else
                    {
                        e.Effects = DragDropEffects.None;
                    }

                }
        }


        public void AddCards(IEnumerable<ViewCard> cardsList, bool refresh)
        {
            foreach(ViewCard card in cardsList)
            {
                card.Column = this;
            }
            cards.AddRange(cardsList);
            if (refresh)
            {
                RefreshCards();
            }
        }

        public void AddCard(ViewCard card, bool refresh = false) 
        {
            card.Column = this;
            cards.Add(card);
            if (refresh)
            {
                RefreshCards();
            }
        }

        public void RefreshCards(int idx = -1)
        {
            Type type = stack.Column.GetType();
            bool decalage;
            switch (type.Name)
            {
                case "Deck":
                case "BaseHeap":
                case "Heap":
                    decalage = false;
                    break;
               
                default:
                    decalage = true;
                    break;
            }
            Canvas.SetLeft(rectangle,X);
            Canvas.SetTop(rectangle,Y);
            if (Count >0)
            {
                if (idx == -1)
                {
                    idx = 0;
                }
                for (int i = idx;i<Count;i++)
                {
                    if (!canvas.Children.Contains(cards[i]))
                    {
                        canvas.Children.Add(cards[i]);
                    }
                    Canvas.SetZIndex(cards[i], i+2);
                }
                double decal = 0;
                if (IsStackSpread)
                {
                    decal = (1.0 - CoverPercent) * ViewCard.InitialHeight;
                }
                double y = Y;
                if (decalage)
                {
                    y += idx * decal;
                }
                
                for (int i = idx; i < Count; i++)
                {
                    Canvas.SetLeft(cards[i],X);
                    Canvas.SetTop(cards[i],y);
                    cards[i].UpdateVisibility();
                    if (decalage)
                    {
                        y+= decal;
                    }
                    
                }
            }
            else
            {
                Canvas.SetLeft(rectangle, X);
                Canvas.SetTop(rectangle, Y);
                if (!canvas.Children.Contains(rectangle)) 
                {
                    canvas.Children.Add(rectangle);
                }
                
            }
        }

        public virtual bool CanDrag(ViewCard viewcard)
        {
            return stack.canDrag(cards.IndexOf(viewcard));
        }

        public bool IsLast(ViewCard viewcard)
        {
            int indice = cards.IndexOf(viewcard);
            if (indice < 0)
            {
                throw new InvalidOperationException("La méthode doit être appelée pour une carte appartenant à la colonne");
            }
            return indice == Count-1;
        }

        public bool Drop(ViewCard viewcard)
        {
            return stack.Drop(viewcard.Column.Stack, viewcard);
        }

        public void MoveCardsFrom(ViewStack from, ViewCard? card = null, bool reverse = false)
        {
            int idx = 0;
            if (card is null)
            {
                if (!reverse)
                {
                    idx = -1;
                }
            }
            else
            {
                idx = from.cards.IndexOf(card);
            }
            if (idx < 0)
            {
                ViewCard lastCard = from.RemoveCard();
                AddCard(lastCard, true);
            }
            else
            {
                List<ViewCard> listCard = from.RemoveCards(idx);
                if (reverse)
                {
                    listCard.Reverse();
                    
                }
                foreach (ViewCard cardList in listCard)
                {
                    AddCard(cardList, true);
                }

            }

        }

        

        

        public List<ViewCard> RemoveCards(int indice)
        {
            if (indice < 0|| indice >= Count)
            {
                throw new ArgumentException($"L’indice {indice} est en-dehors de la plage des indices des cartes de la colonne");
            }
            List<ViewCard> viewCards = new List<ViewCard>();
            while (Count != indice)
            {
                viewCards.Add(cards[indice]);
                cards.RemoveAt(indice);
            }
            RefreshCards();
            return viewCards;
        }

        public void OnMouseLeftButtonClicked(ViewCard card)
        {
            if (cards.IndexOf(card) == Count - 1)
            {
                stack.OnClick();
            }
        }

        public ViewCard RemoveCard()
        {
            ViewCard lastCard = cards[Count - 1];
            cards.RemoveAt(Count - 1);
            return lastCard;
        }

        

    }
}
