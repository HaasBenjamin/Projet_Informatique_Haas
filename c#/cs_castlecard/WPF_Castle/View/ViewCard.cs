using CastleModel;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.CompilerServices;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Input;
using System.Windows.Media.Effects;
using System.Windows.Media.Imaging;
using WPF_Castle.ViewModel;

namespace WPF_Castle.View
{
    public class ViewCard: System.Windows.Controls.Image
    {
        private BitmapImage cardImage;
        private static BitmapImage background;
        private VMCard vmCard;

        public static double InitialWidth;
        public static double InitialHeight;

        private bool canDrag = false;

        private ViewStack? column;

        public ViewStack? Column { get { return column; } set { column = value; } }

        public VMCard VmCard {  get { return vmCard; } }

        static ViewCard()
        {
            ViewCard.background = new BitmapImage(new Uri($"pack://application:,,,/WPF_Castle;component/Images/fond.png", UriKind.RelativeOrAbsolute));
            ViewCard.InitialHeight = background.Height;
            ViewCard.InitialWidth = background.Width;
        }

        public ViewCard( VMCard card)
        {
            vmCard = card;
            cardImage = new BitmapImage(new Uri($"pack://application:,,,/WPF_Castle;component/Images/{card.ImageName}", UriKind.RelativeOrAbsolute)); ;
            this.Source = cardImage;
            if (card.Hidden == true )
            {
                this.Source = background;
            }
            this.AllowDrop = true;
        }

        protected override void OnMouseLeftButtonDown(MouseButtonEventArgs e)
        {
            /*
            if (!vmCard.Hidden)
            {
                MessageBox.Show($"Vous avez cliqué sur la carte {vmCard}...");
            }*/
            canDrag = true;
                
        }

        protected override void OnMouseMove(MouseEventArgs e)
        {
            if (e.LeftButton == MouseButtonState.Pressed && canDrag && column.CanDrag(this))
            {
                DragDropEffects effet = DragDrop.DoDragDrop(this, this, DragDropEffects.Move);
                if (effet == DragDropEffects.None)
                {
                    canDrag = false;
                }


                    
            }
        }

        protected override void OnMouseLeftButtonUp(MouseButtonEventArgs e)
        {
            if (canDrag)
            {
                canDrag = false;
                column.OnMouseLeftButtonClicked(this);
            }
        }

        public void UpdateVisibility()
        {
            if (this.vmCard.Hidden == true)
            {
                this.Source = background;
            }
            else
            {
                this.Source = cardImage;
            }
        }

        protected override void OnDrop(DragEventArgs e)
        {
            if (e.Data.GetDataPresent(typeof(ViewCard)))
            if (e.Data.GetDataPresent(typeof(ViewCard)))
            {
                if (!this.column.IsLast(this))
                {
                    e.Effects = DragDropEffects.None;
                }
                else
                {
                    ViewCard card = (ViewCard)e.Data.GetData(typeof(ViewCard));
                    if (card == null || card == this) 
                    {
                        e.Effects = DragDropEffects.None;
                    }
                    else
                    {
                        if(column.Drop(card))
                        {
                            e.Handled = true;
                        }
                        else
                        {
                            e.Effects = DragDropEffects.None;
                        }
                    }
                }
            }

        }

    }
}
