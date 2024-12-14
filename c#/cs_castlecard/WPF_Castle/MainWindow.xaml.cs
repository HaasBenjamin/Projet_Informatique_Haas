using CastleModel;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;
using WPF_Castle.View;
using WPF_Castle.ViewModel;

namespace WPF_Castle
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        public MainWindow()
        {
            InitializeComponent();
            /*
            ViewCard card1 = new ViewCard(new VMCard(new Card(3, Card.Suit.DIAMOND, true)));
            canvasTapis.Children.Add(card1);
            Canvas.SetLeft(card1, 10);
            Canvas.SetTop(card1, 10);
            ViewCard card2 = new ViewCard(new VMCard(new Card(10, Card.Suit.HEART, false)));
            canvasTapis.Children.Add(card2);
            Canvas.SetLeft(card2, 20);
            Canvas.SetTop(card2, 10);
            ViewCard card3 = new ViewCard(new VMCard(new Card(8, Card.Suit.DIAMOND, false)));
            canvasTapis.Children.Add(card3);
            Canvas.SetLeft(card3, 30);
            Canvas.SetTop(card3, 10);

            List<ViewCard> l1 = new List<ViewCard>
            {
                new ViewCard(new VMCard(new Card(1, Card.Suit.CLUB, true))),
                new ViewCard(new VMCard(new Card(6, Card.Suit.DIAMOND, true))),
                new ViewCard(new VMCard(new Card(12, Card.Suit.SPADE, true))),
                new ViewCard(new VMCard(new Card(10, Card.Suit.CLUB, true))),
                new ViewCard(new VMCard(new Card(7, Card.Suit.HEART, true))),
                new ViewCard(new VMCard(new Card(8, Card.Suit.DIAMOND, true))),
            };

            List<ViewCard> l2 = new List<ViewCard>
            {
                new ViewCard(new VMCard(new Card(3, Card.Suit.SPADE, true))),
                new ViewCard(new VMCard(new Card(13, Card.Suit.HEART, true))),
            };
            ViewCanvas canvas = new ViewCanvas();
            ViewStack v1 = new ViewStack(canvasTapis,null);
            v1.X = 10;
            v1.AddCards(l1 ,true);
            ViewStack v2 = new ViewStack(canvasTapis, null);
            v2.X = ViewCard.InitialWidth + 20;
            v2.AddCards(l2, true);
            ViewStack v3 = new ViewStack(canvasTapis, null);
            v3.X = 2 * ViewCard.InitialWidth + 30;
            v3.RefreshCards(); */
            VMCastle castle = new VMCastle(new Castle());
            ViewCastle view = new ViewCastle(canvasTapis, castle); 

        }
    }
}
