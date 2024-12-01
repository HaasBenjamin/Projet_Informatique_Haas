using CastleModel;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TestCastleModel
{
    [TestClass]
    public class UnitTestCastle
    {
        [TestMethod]
        public void TestGetPile()
        {
            Castle castle = new Castle();
            Move.Pile pile = new Move.Pile();
            pile.Name = Move.PileName.COLUMN;
            pile.Number = 3;
            Assert.AreEqual(castle.Column[2],castle.GetPile(pile));
            pile.Name = Move.PileName.BASEHEAP;
            pile.Number = 2;
            Assert.AreEqual(castle.BaseHeaps[1], castle.GetPile(pile));
            pile.Name = Move.PileName.HEAP;
            pile.Number = 1;
            Assert.AreEqual(castle.Heaps[0], castle.GetPile(pile));
        }

        [TestMethod]
        public void TestEncodeDecode()
        {
            // Tests répétitifs
            for (int i = 0; i < 100; ++i)
            {
                Castle c1 = new Castle();
                c1.Distribute();
                // On applique un nombre aléatoire de déplacements
                int nb = UnitTestPile.rnd.Next(20);
                List<Move> moves = c1.SearchAllMoves();
                while (--nb >= 0 && moves.Count > 0)
                {
                    c1.ApplyMove(moves[0]);
                    moves = c1.SearchAllMoves();
                }
                string encodage = c1.Encode();
                Castle c2 = new Castle();
                c2.Decode(encodage);
                Assert.AreEqual(encodage, c2.Encode());
            }

        }
    }
}
