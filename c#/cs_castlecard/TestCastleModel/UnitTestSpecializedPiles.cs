using CastleModel;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TestCastleModel
{
    [TestClass]
    public class UnitTestSpecializedPiles
    {
        [TestMethod]
        public void TestSpecializedPileMethods()
        {
            Card carte1 = new Card(new Card.Face(5), Card.Suit.HEART, false);
            Card carte2 = new Card(new Card.Face(6), Card.Suit.HEART, false);
            Card carte3 = new Card(new Card.Face(4), Card.Suit.HEART, false);
            Card carte4 = new Card(new Card.Face(1), Card.Suit.HEART, false);
            Card carte5 = new Card(new Card.Face(2), Card.Suit.HEART, false);
            Column column = new Column();
            column.Push(carte1);
            Assert.AreEqual(true, column.CanPush(carte3));
            Assert.AreEqual(false, column.CanPush(carte2));
            BaseHeap heap = new BaseHeap();
            heap.Push(carte4);
            Assert.AreEqual(false, heap.CanPush(carte1));
            Assert.AreEqual(false, heap.CanPush(carte2));
            Assert.AreEqual(false, heap.CanPush(carte3));
            Assert.AreEqual(true, heap.CanPush(carte5));
        }

        [DataTestMethod]
        [DataRow(1, 1)]
        [DataRow(2, 7)]
        [DataRow(3, 11)]
        [DataRow(4, 13)]
        public void TestBaseHeadEncodeOneCard(int color, int value)
        {
            Card c = new Card(value, (Card.Suit)color, true);
            BaseHeap heap = new BaseHeap();
            heap.Decode(c.Encode().ToString());
            Assert.AreEqual(value, heap.Count, "Erreur sur le nombre de cartes.");
            int i = 1;
            foreach (Card _c in heap)
            {
                Assert.AreEqual(i, _c.Figure.Value, "Problème sur les valeurs de figure");
                Assert.AreEqual(c.Color, _c.Color, "Problème sur la couleur des cartes");
                Assert.IsTrue(c.Visible, "Les cartes doivent être visibles");
                ++i;
            }
        }
        [TestMethod]
        public void TestBaseHeapDecodeError()
        {
            BaseHeap heap = new BaseHeap();
            // Une pile de base ne peut pas être vide
            Assert.ThrowsException<ArgumentException>(() => heap.Decode(""));
            // Le décodage n'accepte qu'un seul caractère
            Assert.ThrowsException<ArgumentException>(() => heap.Decode("AB"));
            Assert.ThrowsException<ArgumentException>(() => heap.Decode("ABC"));
            Assert.ThrowsException<ArgumentException>(() => heap.Decode("ABCD"));
        }
        [TestMethod]
        public void TestColumnEncodeDecode()
        {
            Column pile = new Column();
            // Test aléatoire répétitif
            for (int i = 0; i < 1000; ++i)
            {
                // Choix de deux cartes
                Card c1 = UnitTestPile.CreateCard();
                if (c1.Figure.Value == 1) continue;
                Card c2 = new Card(c1.Figure.Value - UnitTestPile.rnd.Next(c1.Figure.Value), c1.Color, true);
                string encodage = c1.Encode().ToString() + c2.Encode().ToString();
                pile.Decode(encodage);
                Assert.AreEqual(encodage, pile.Encode(), "Problème avec l'encodage ou le décodage ??");
                Assert.AreEqual(c1.Figure.Value - c2.Figure.Value + 1, pile.Count,
                "Problème sur le nombre de cartes");
                int j = 0;
                foreach (Card c in pile)
                {
                    Assert.AreEqual(c1.Figure.Value - j, c.Figure.Value);
                    Assert.AreEqual(c1.Color, c.Color);
                    Assert.IsTrue(c.Visible, "Les cartes doivent êre visibles");
                    ++j;
                }
            }
        }
        [TestMethod]
        public void TestColumnDecodeError()
        {
            string Encode(Card c1, Card c2)
            {
                return string.Join("", c1.Encode(), c2.Encode());
            }
            // Il doit accepter le décodage vide
            Column column = new Column();
            for (int i = 0; i < 10; ++i)
            {
                column.Push(UnitTestPile.CreateCard());
            }
            column.Decode("");
            Assert.IsTrue(column.Empty, "Erreur sur le décodage d'une pile vide");
            // Il ne doit accepter que 0 ou 2 caractères
            Assert.ThrowsException<ArgumentException>(() => column.Decode("A")); Assert.ThrowsException<ArgumentException>(() => column.Decode("ABC"));
            Assert.ThrowsException<ArgumentException>(() => column.Decode("ABCD"));
            // La première carte doit avoir une valeur plus grande que la seconde
            Card c1 = new Card(5, Card.Suit.HEART, true);
            Card c2 = new Card(10, Card.Suit.HEART, true);
            Assert.ThrowsException<ArgumentException>(() => column.Decode(Encode(c1, c2)));
            // Les deux cartes doivent avoir la même couleur
            c2 = new Card(2, Card.Suit.DIAMOND, true);
            Assert.ThrowsException<ArgumentException>(() => column.Decode(Encode(c1, c2)));
            // Cas d'une colonne avec une seule carte
            column.Decode(Encode(c1, c1));
            Assert.AreEqual(1, column.Count, "Erreur sur le décodage d'une pile d'une seule carte...");
            Assert.AreEqual(c1, column.Last);
        }

        [TestMethod]
        public void TestDeckEncodeDecode()
        {
            // Test aléatoire répétitif du même style que la pile
            List<Card> cards = new List<Card>();
            Deck deck = new Deck();
            for (int i = 0; i < 1000; ++i)
            {
                int nb = UnitTestPile.rnd.Next(10);
                cards.Clear();
                while (--nb >= 0)
                {
                    cards.Add(UnitTestPile.CreateCard());
                }
                string encodage = string.Join("", from _c in cards select _c.Encode());
                deck.Decode(encodage);
                Assert.AreEqual(cards.Count, deck.Count, "Problème sur le nombre de cartes");
                Assert.AreEqual(encodage, deck.Encode(), "Problème sur l'encodage/décodage ??");
                int j = 0;
                foreach (Card c in deck)
                {
                    Assert.AreEqual(cards[j].Figure.Value, c.Figure.Value, "Problème sur les valeurs des cartes");
                    Assert.AreEqual(cards[j].Color, c.Color, "Problème sur les couleurs des cartes");
                    Assert.IsFalse(c.Visible, "Les cartes ne doivent pas être visibles");
                    ++j;
                }
            }
        }

    }
}
