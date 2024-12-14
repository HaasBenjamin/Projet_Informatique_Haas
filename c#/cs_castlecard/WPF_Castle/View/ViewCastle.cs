using CastleModel;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Controls;
using WPF_Castle.ViewModel;

namespace WPF_Castle.View
{
    public class ViewCastle
    {
        private readonly ViewStack[] heaps = new ViewStack[3];
        private readonly ViewStack[] bases = new ViewStack[4];
        private readonly ViewStack[] columns = new ViewStack[6];
        private readonly ViewStack deck;


        public const int MARGIN = 18;

        public ViewCastle(ViewCanvas canvas,VMCastle castle)
        {
            int max = 0;
            int i = 0;
            foreach (VMStack col in castle.Columns)
            {
                columns[i] = new ViewStack(canvas, col);
                ViewStack stack = col.CreateViewStack(canvas);
                stack.X = 170 + (MARGIN + ViewCard.InitialWidth) *i;
                stack.Y = 10;
                stack.RefreshCards();
                if (stack.Count > max)
                {
                    max = stack.Count;
                }
                i++;
            }
            i = 0;
            (int,int)[] coord = new (int, int)[]
                {
                    (48,76 ),
                    (48,246 + MARGIN*(max-1)),
                    (748 ,76),
                    (748 ,246 + MARGIN*(max-1))
                };
            foreach (VMStack bh in castle.BasesHeap)
            {
                bases[i] = new ViewStack(canvas, bh);
                ViewStack stack = bh.CreateViewStack(canvas);
                stack.X = coord[i].Item1;
                stack.Y = coord[i].Item2;
                stack.RefreshCards(stack.Count - 1);
                i++;
            }
            i = 0;
            foreach (VMStack heap in castle.Heaps)
            {
                heaps[i] = new ViewStack(canvas, heap);
                ViewStack stack = heap.CreateViewStack(canvas);
                stack.X = 300 + (MARGIN + ViewCard.InitialWidth) * i;
                stack.Y = 390 + MARGIN * (max - 1);
                stack.RefreshCards(stack.Count - 1);
                i++;
            }
            deck = new ViewStack(canvas,castle.Deck);
            ViewStack stackdeck = castle.Deck.CreateViewStack(canvas);
            stackdeck.X = 200;
            stackdeck.Y = 390 + MARGIN * (max - 1);
            stackdeck.RefreshCards(stackdeck.Count - 1);

        }

    }
}
