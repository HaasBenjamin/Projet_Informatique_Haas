using CastleModel;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TestCastleModel
{
    [TestClass]
    public class UnitTestMove
    {
        [TestMethod]
        public void TestConstructor()
        {
            Castle castle = new Castle();
            Move move = new Move("D",castle);
            Assert.AreEqual(Move.PileName.DECK, move.From.Name);
            Assert.AreEqual(1, move.From.Number);
            Assert.IsNull(move.To);
            move = new Move("C3 B", castle);
            Assert.AreEqual(Move.PileName.COLUMN, move.From.Name);
            Assert.AreEqual(3, move.From.Number);
            Assert.AreEqual(Move.PileName.BASEHEAP, move.To.Name);
            Assert.IsNull(move.To.Number);
            Assert.ThrowsException<ArgumentException>(() => new Move("D4", castle));

        }


    }
}
