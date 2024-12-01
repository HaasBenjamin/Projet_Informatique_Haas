using CastleModel;

public class ConsoleCard
{
    #region const
    private const char left_up_corner = '\u250C';
    private const char horiz_corner = '\u2500';
    private const char right_up_corner = '\u2510';
    private const char vert_corner = '\u2502';
    private const char left_dwn_corner = '\u2514';
    private const char right_dwn_corner = '\u2518';
    private const char left_up_corner2 = '\u2554';
    private const char horiz_corner2 = '\u2550';
    private const char right_up_corner2 = '\u2557';
    private const char vert_corner2 = '\u2551';
    private const char left_dwn_corner2 = '\u255A';
    private const char right_dwn_corner2 = '\u255D';
    private const char _background = '\u2592';
    private const char _trefle = '\u2663';
    private const char _coeur = '\u2665';
    private const char _carre = '\u2666';
    private const char _pique = '\u2660';
    public const int LARGEUR = 5;
    public const int HAUTEUR = 5;
    private const ConsoleColor _backgroundColor = ConsoleColor.DarkGreen;
    private const ConsoleColor _foregroundColor = ConsoleColor.Black;
    #endregion
    private CharCase?[,] screen;
    public int NbLines { get; private set; }
    public int NbColumns { get; private set; }
    public ConsoleCard(int nbLines = -1, int nbColumns = -1)
    {
        if (nbLines == -1 || nbLines >= Console.WindowHeight)
        {
            nbLines = Console.WindowHeight;
        }
        if (nbColumns == -1 || nbColumns >= Console.WindowWidth)
        {
            nbColumns = Console.WindowWidth;
        }
        NbLines = nbLines;
        NbColumns = nbColumns;
        screen = new CharCase[nbLines, nbColumns];
        Console.SetWindowSize(nbColumns, nbLines);
    }
    public CharCase? this[int li, int co]
    {
        get
        {
            CharCase? result = null;
            try
            {
                result = screen[li, co];
            }
            catch (Exception) { };
            return result;
        }
        set
        {
            try
            {
                screen[li, co] = value;
            }
            catch (Exception) { }
        }

    }

    public void Print(string s, int column, int li,
 ConsoleColor fg = _foregroundColor, ConsoleColor bg = _backgroundColor)
    {
        for (int i = 0, co = column; i < s.Length && co < screen.GetLength(1); ++i, ++co)
        {
            this[li, co] = new CharCase
            {
                Char = s[i],
                BackgroundColor = bg,
                Color = fg
            };
        }
    }
    public void Print(Card? c, int column, int line)
    {
        int li = line;
        int co = column;
        if (c is null)
        {
            ConsoleColor bg = _backgroundColor;
            ConsoleColor fg = _foregroundColor;
            int i;
            // Première ligne
            this[li, co] = new CharCase
            {
                Char = left_up_corner,
                Color = fg,
                BackgroundColor = bg
            };
            for (i = 1; i <= 3; ++i)
                this[li, co + i] = new CharCase
                {
                    Char = horiz_corner,
                    Color = fg,
                    BackgroundColor = bg
                };
            this[li, co + 4] = new CharCase
            {
                Char = right_up_corner,
                Color = fg,
                BackgroundColor = bg
            };
            // Trois lignes suivantes
            int j;
            for (i = 1; i <= 3; ++i)
            {
                for (j = 0; j < 5; ++j)
                {
                    this[li + i, co + j] = new CharCase
                    {
                        Char = j == 0 || j == 4 ? vert_corner : ' ',
                        Color = fg,
                        BackgroundColor = bg
                    };
                }
            }
            char car;
            for (i = 0; i <= 4; ++i)
            {
                if (i == 0) car = left_dwn_corner;
                else if (i == 4) car = right_dwn_corner;
                else car = horiz_corner;
                this[li + 4, co + i] = new CharCase
                {
                    Char = car,
                    Color = fg,
                    BackgroundColor = bg
                };
            }
        }
        else
        {
            ConsoleColor forecolor = ConsoleColor.Cyan;
            ConsoleColor bg = ConsoleColor.Black;
            char color = ' ';
            switch (c.Color)
            {
                case Card.Suit.SPADE:
                    color = _pique;
                    break;
                case Card.Suit.CLUB:
                    color = _trefle;
                    break;
                case Card.Suit.HEART:
                    color = _coeur;
                    forecolor = ConsoleColor.Red;
                    break;
                default:
                    color = _carre;
                    forecolor = ConsoleColor.Red;
                    break;
            }
            string face = c.Figure.ToString();
            string lface = face + " ";
            string rface = " " + face;
            if (c.Figure.Value == 10)
                lface = rface = face;
            if (!c.Visible) forecolor = ConsoleColor.White;
            char[] car = new char[5];
            for (int i = 0; i <= 4; ++i)
            {
                if (i == 0)
                {
                    car[0] = left_up_corner2;
                    car[1] = car[2] = car[3] = horiz_corner2;
                    car[4] = right_up_corner2;
                }
                else if (i == 4)
                {
                    car[0] = left_dwn_corner2;
                    car[4] = right_dwn_corner2;
                    car[1] = car[2] = car[3] = horiz_corner2;
                }
                else
                {
                    car[0] = car[4] = vert_corner2;
                    if (c.Visible)
                    {
                        switch (i)
                        {
                            case 1:
                                car[1] = lface[0]; car[2] = lface[1];
                                car[3] = color;
                                break;
                            case 2:
                                car[1] = car[3] = ' ';
                                car[2] = color;
                                break;
                            case 3:
                                car[1] = color;
                                car[2] = rface[0]; car[3] = rface[1];
                                break;
                        }
                    }
                    else
                    {
                        car[1] = car[2] = car[3] = _background;
                    }
                }
                for (int j = 0; j <= 4; ++j)
                {
                    this[li + i, co + j] = new CharCase
                    {
                        Char = car[j],
                        Color = forecolor,
                        BackgroundColor = bg
                    };
                }
            }
        }
    }
    public int LastLine
    {
        get
        {
            int li = screen.GetLength(0) - 1;
            bool empty = true;
            while (li > 0 && empty)
            {
                int co = 0;
                while (co < screen.GetLength(1) && screen[li, co] is null)
                    ++co;
                empty = co == screen.GetLength(1);
                if (empty)
                {
                    --li;
                }
            }
            return li;
        }
    }
    public void Refresh()
    {
        Console.Clear();
        ConsoleColor bg_previous = Console.BackgroundColor;
        ConsoleColor previous = Console.ForegroundColor;
        int lastLine = LastLine;
        // Affichage de l'écran !
        for (int li = 0; li <= lastLine; ++li)
        {
            ConsoleColor color = screen[li, 0] is null ? _foregroundColor : screen[li, 0].Color;
            ConsoleColor bg_color = screen[li, 0] is null ? _backgroundColor :
            screen[li, 0].BackgroundColor;
            string s = "";
            for (int co = 0; co < screen.GetLength(1); ++co)
            {
                if (screen[li, co] is null)
                {
                    screen[li, co] = new CharCase
                    {
                        Char = ' ',
                        Color = color,
                        BackgroundColor = _backgroundColor
                    };
                }
                if (screen[li, co].Color == color && screen[li, co].BackgroundColor == bg_color)
                {
                    s += screen[li, co].Char;
                }
                else
                {
                    if (s.Length > 0)
                    {
                        Console.ForegroundColor = color;
                        Console.BackgroundColor = bg_color;
                        Console.Write(s);
                    }
                    color = screen[li, co].Color;
                    bg_color = screen[li, co].BackgroundColor;
                    s = screen[li, co].Char.ToString();
                }
            }
            Console.ForegroundColor = color;
            Console.BackgroundColor = bg_color;
            Console.WriteLine(s);
        }
        Console.WriteLine();
        Console.ForegroundColor = previous;
        Console.BackgroundColor = bg_previous;


    }

    public void Clear()
    {
        for (int i = 0; i < NbLines; ++i)
        {
            for (int j = 0; j < NbColumns; ++j)
            {
                screen[i, j] = null;
            }
        }
    }

    public void Print(Pile pile,int col, int lig)
    {
        if (pile.Empty)
        {
            Print(null as Card, col, lig);
        }
        else
        {
            Print(pile.Last, col, lig);
        }
    }

    public void Print(Column column, int col, int lig)
    {
            IEnumerator<Card> it = column.GetEnumerator();
            int i = 0;
            bool next = it.MoveNext();
            while (next)
            {
            Card card = it.Current;
            Print(card, col, lig + i * 2);
            next = it.MoveNext();
            i++;
            }
        
    }

    public void Print(Castle castle)
    {
        List<BaseHeap> baseheap = castle.BaseHeaps;
        Print(baseheap[0], 0, 5);
        Print(baseheap[0].Name + "1", 1, 10);
        Print(baseheap[1], 0, 12);
        Print(baseheap[0].Name + "2", 1, 17);
        Print(baseheap[2], 55, 5);
        Print(baseheap[0].Name + "3", 56, 10);
        Print(baseheap[3], 55, 12);
        Print(baseheap[0].Name + "4", 56, 17);

        int i = 0;
        foreach(Column column in castle.Column)
        {
            Print(column, 10 + 7 * i, 3);
            Print($"{column.Name}{i+1}",10+7*i,5+3*column.Count);
            i++;
        }
        i=0;
        int max = 0;
        foreach (Column column in castle.Column)
        {
            if (column.Count > max)
            {
                max = column.Count;
            }
        }
        foreach (Heap heap in castle.Heaps)
        {
            Print(heap, 23 + 7 * i, 17 + max);
            Print($"{heap.Name}{i + 1}", 23 + 7 * i, 22 + max);
            i++;
        }
        Print(castle.Deck[0]  , 15, 17 + max);
        Print($"{castle.Deck[0].Name} ({castle.Deck[0].Count})", 15, 22 + max);

    }
}

public class CharCase
{
    public ConsoleColor BackgroundColor { get; set; }
    public char Char { get; set; }
    public ConsoleColor Color { get; set; }
    
}