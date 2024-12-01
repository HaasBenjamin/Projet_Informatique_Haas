using CastleModel;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TestCastleModel
{
    [TestClass]
    public class UnitTestPile
    {
        public static Random rnd = new Random();
        public class TestPile:Pile
        {
            public override bool CanPush(Card c)
            {
                return true;
            }

            public override Move.Pile MovePile
            {
                get
                {
                    Move.Pile pile = new Move.Pile();
                    pile.Number = this.Number;
                    return pile;

                }
            }
        }

        [TestMethod]
        public void TestPileMethods()
        {
            TestPile testPile = new TestPile();
            Assert.AreEqual(true, testPile.Empty);
            Assert.AreEqual(false, testPile.CanPop());
            Assert.AreEqual(0, testPile.Count);
            Card carte1 = new Card(new Card.Face(5), Card.Suit.HEART, false);
            testPile.Push(carte1);
            Assert.AreEqual(carte1, testPile.Last);
            Assert.AreEqual(1, testPile.Count);
            Assert.AreEqual(false, testPile.Empty);
            Assert.AreEqual(true,testPile.CanPop());
            testPile.Push(carte1);
            testPile.Pop();
            Assert.AreEqual(1, testPile.Count);
        }

        [TestMethod]
        public void TestEncodeDecode()
        {
            // Test de la pile vide
            TestPile pile = new TestPile();
            Assert.AreEqual("", pile.Encode(), "Problème sur l'encodage d'une pile vide");
            // On remplit aléatoirement la pile
            for (int i = 0; i < 5; ++i)
            {
                pile.Push(CreateCard());
            }
            // On décode une pile vide
            pile.Decode("");
            Assert.IsTrue(pile.Empty, "Problème du décodage d'une pile vide...");
            // Test aléatoire répétitif avec des cartes
            List<Card> list = new List<Card>();

            for (int i = 0; i < 1000; ++i)
            {
                int nb = rnd.Next(10);
                list.Clear();
                pile.Clear();
                // Remplissage des piles
                while (--nb >= 0)
                {
                    Card c = CreateCard();
                    list.Add(c);
                    pile.Push(c);
                }
                // Test de l'encodage
                string encodage = string.Join("", from c in list select c.Encode());
                Assert.AreEqual(encodage, pile.Encode(), "Problème avec l'encodage...");
                // Test du décodage
                pile.Clear();
                pile.Decode(encodage);
                Assert.AreEqual(list.Count, pile.Count,
                "Problème dans le décodage sur le nombre de cartes");
                int j = 0;
                foreach (Card c in pile)
                {
                    Assert.AreEqual(list[j], c, "Problème dans le décodage des cartes de la pile...");
                    Assert.IsTrue(c.Visible, "Les cartes doivent être visibles dans la pile...");
                    j++;
                }
            }

        }

        public static Card CreateCard()
        {
            Card carte1 = new Card(new Card.Face(rnd.Next(1,13)), (Card.Suit)rnd.Next(1, 4), true);
            return carte1;
        }
    }

}
