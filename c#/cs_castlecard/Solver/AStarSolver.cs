using CastleModel;
using System.Data;
using static Solver.AStarSolver;

namespace Solver
{
    public class AStarSolver
    {
        private SortedDictionary<string, Node?> steps = new SortedDictionary<string, Node?>();
        private readonly Node tree;

        public int Score
        {
            get { return tree.Score; }
        }

        public bool Solved
        {
            get
            {
                return Score == 0;
            }
        }

        public bool HasNoSolution
        {
            get
            {
                return Score < 0;
            }
        }

        public int Depth 
        { 
            get
            {
                return tree.Depth;
            }
        }
        
        public static int Evaluate(Castle castle)
        {
            int scoreB = 0;
            int nbCartesBase = 0;
            foreach(BaseHeap baseh in castle.BaseHeaps)
            {
                scoreB += (13 - baseh.Count);
                nbCartesBase += baseh.Count;
            }
            int scoreC = 52-nbCartesBase;
            int nbColVide = 0;
            foreach (Column col in castle.Column)
            {
                if (col.Empty)
                {
                    nbColVide++;
                }
                scoreC-=col.Count;
            }
            scoreC +=  (6 - nbColVide);
            int scoreH = 0;
            foreach (Heap h in castle.Heaps)
            {
                scoreH += h.Count;
            }
            int scoreD = 0;
            foreach (Deck dec in castle.Deck)
            {
                scoreD += dec.Count;
            }

            return (int)(scoreB + 0.7 * scoreC + 0.4 * scoreH + 0.25 * scoreD);
        }

        public class Node
        {
            private readonly AStarSolver solver;
            private Castle? castle;
            private readonly Move? move;
            private readonly int depth;
            private int score;
            private readonly List<Node> children;
            private readonly Node? parent;
            private readonly string encode;

            public int Score { get => score; }
            public Castle? Castle { get => castle; }
            public List<Node> Children { get => children; }
            public string Encode { get => encode; }
            public AStarSolver Solver { get => solver; }

            public string Move
            {
                get { return this.move != null ?  this.move.ToString(): "Aucun mouvement"; }
            }

            public int Depth
            {
                get
                {
                    if (this.children.Count == 0)
                    {
                        return this.depth;
                    }
                    return (from c in children select c.Depth).Max();
                }
            }

            public Node(AStarSolver solver,Castle castle)
            {
                this.solver = solver;
                this.castle = castle;
                this.parent = null;
                this.move = null;
                this.depth = 0;
                this.score = AStarSolver.Evaluate(castle);
                this.children = new List<Node>();
                this.encode = castle.Encode();
            }

            private Node(Node? parent, Move? move)
            {
                this.solver = parent.Solver;
                this.parent = parent;
                this.depth = parent.depth + 1;
                this.move = move;
                this.castle = new Castle(parent.castle);
                this.children = new List<Node>();
                this.castle.ApplyMove(move);
                this.score = AStarSolver.Evaluate(castle);
                this.encode = this.castle.Encode();
            }

            public static Node? Create(Node parent,Move move)
            {
                Node fils =  new Node(parent, move);
                if (parent.Solver.Contains(fils))
                {
                    return null;
                }
                parent.Solver.Add(fils);
                return fils;
            }

            public bool Develop()
            {
                if (this.Score <= 0)
                {
                    return false;
                }
                if (this.children.Count !=0)
                {
                    return this.children[0].Develop();
                }
                List<Move> moves = this.castle.SearchAllMoves();
                foreach (Move move in moves)
                {
                    Node? nod = Create(this, move);
                    if (nod != null)
                    {
                        this.children.Add(nod);
                    }
                }
                this.castle = null;
                if (this.children.Count == 0)
                {
                    Remove();
                }
                else
                {
                    UpdateScores();
                }
                return true;
            }

            private void UpdateScores()
            {
                this.children.Sort(delegate (Node x, Node y)
                {
                    if (x.Score > y.Score) {  return 1; }
                    else if (x.Score < y.Score) { return -1; }
                    else { return 0; }
                });
                if (this.children[0].Score != this.Score)
                {
                    this.score = this.children[0].Score;
                    if (parent != null)
                    {
                        parent.UpdateScores();
                    }
                }
            }

            private void Remove()
            {
                if (parent != null)
                {
                    parent.solver.Remove(this);
                    parent.Remove(this);
                }
                else
                {
                    this.score = -1;
                }
            }

            private void Remove(Node node)
            {
                int ind = this.children.IndexOf(node);
                if (ind < 0)
                {
                    throw new InvalidOperationException("Tentative de suppression d’un nœud ne se trouvant pas dans la liste des fils");
                }
                else
                {
                    this.children.RemoveAt(ind);
                    if (this.children.Count == 0)
                    {
                        this.Remove();
                    }
                    else
                    {
                        if (ind == 0)
                        {
                            if (this.children[0].Score != this.Score)
                            {
                                this.score = this.children[0].Score;
                                if (parent != null)
                                {
                                    parent.UpdateScores();
                                }
                            }
                        }
                    }
                }
            }

            public void VerifyIntegrity()
            {
                if (this.parent != null)
                {
                    if ( !( (this.castle == null && this.children.Count != 0) || (this.castle != null && this.children.Count == 0) ) ) 
                    {
                        throw new InvalidOperationException("Incohérence entre la nullité du castle et de la présence des fils");
                    }
                }
                int oldScore = 0;
                foreach (Node fils in this.children)
                {
                    if ( fils.depth != this.depth + 1)
                    {
                        throw new InvalidOperationException("Incohérence sur la profondeur des fils");
                    }
                    if ( fils.parent != this)
                    {
                        throw new InvalidOperationException("Le père du fils n'est pas le noeud");
                    }
                    if ((fils.score < oldScore))
                    {
                        throw new InvalidOperationException("La liste des fils n'est pas triée par ordre croissant");
                    }
                    oldScore = fils.score;
                }
                if (this.children.Count != 0)
                {
                    if (this.Score != this.children[0].Score)
                    {
                        throw new InvalidOperationException("Score incohérent entre père et 1er fils");
                    }
                }
                foreach (Node fils in this.children)
                {
                    fils.VerifyIntegrity();
                }
            }
        }

        private void Remove(Node node)
        {
            if (this.Contains(node))
            {
                this.steps[node.Encode] = null;
            }
            else
            {
                throw new InvalidOperationException("Tentative de suppression d’un nœud ne se trouvant pas dans le dictionnaire ???");

            }
        }

        private void Add(Node fils,bool noVerification = false)
        {
            if (!noVerification)
            {
                if (!this.Contains(fils))
                {
                    this.steps.Add(fils.Encode, fils);
                }
                else
                {
                    throw new InvalidOperationException("Tentative d’ajout d’un nœud déjà existant !??");
                }
            }
            else
            {
                this.steps.Add(fils.Encode, fils);
            }
        }

        private bool Contains(Node fils)
        {
            return this.steps.ContainsKey(fils.Encode);
        }

        public AStarSolver(Castle castle)
        {
            this.tree = new Node(this, castle);
        }

        public bool Develop() => tree.Develop();

        public void VerifyIntegrity()
        {
            tree.VerifyIntegrity();
        }

        public void AfficherSolution()
        {
            do
            {
                Develop();
                VerifyIntegrity();
            } while (HasNoSolution == false && Solved == false );
            int nb_moves = 0;
            foreach (Node node in this.steps.Values) 
            {
                Console.WriteLine(node.Move);
                nb_moves++;
                if (nb_moves == 5)
                {
                    break;
                }
            }

            
        }

    }
}