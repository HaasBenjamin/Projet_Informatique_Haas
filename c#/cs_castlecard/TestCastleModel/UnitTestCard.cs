using CastleModel;
using TestCastleModel;
using static CastleModel.Card;

namespace TestCastleModel
{

    [TestClass]
    public class UnitTestCard
    {

        [TestMethod]
        public void TestFaceConstructor()
        {
            Face facetmp;
            for (int i = 1; i < 14; i++)
            {
                facetmp = new Face(i);
                Assert.AreEqual(i , facetmp.Value);
            }
            string[] figures = { "A", "J", "Q", "K" };
            int[] figures_num = { 1, 11, 12, 13 };
            for (int i = 0; i < figures.Length; i++)
            {
                facetmp = new Face(figures[i]);
                Assert.AreEqual(figures_num[i], facetmp.Value);
            }
        }
        [DataTestMethod]
        [DataRow(0)]
        [DataRow(14)]
        [DataRow("Valet")]
        [DataRow("0")]
        public void TestFaceConstructorException(object o)
        {
            if (o is string s)
            {
                Assert.ThrowsException<ArgumentOutOfRangeException>(() => new Face(s));
            }
            else if (o is int n)
            {
                Assert.ThrowsException<ArgumentOutOfRangeException>(() => new Face(n));
            }
        }

        [DataTestMethod]
        [DynamicData(nameof(GetCards), DynamicDataSourceType.Method)]
        public void TestCanCover(Card c1, Card c2, bool res, string msg)
        {
            Assert.AreEqual(res, c1.CanCover(c2), msg);
        }
        public static IEnumerable<object[]> GetCards()
        {
            // Cas de cartes pouvant se recouvrir
            Card[,] cards = new Card[,] {
 { new Card(2, Card.Suit.HEART, true), new Card(3, Card.Suit.HEART, true) },
 { new Card(5, Card.Suit.DIAMOND, true), new Card(6, Card.Suit.DIAMOND, true)},
 { new Card(10, Card.Suit.SPADE, true), new Card(11, Card.Suit.SPADE, true) },
 { new Card(7, Card.Suit.CLUB, true), new Card(8, Card.Suit.CLUB, true) },
 };
            for (int i = 0; i < cards.GetLength(0); i++)
            {
                yield return new object[]
                {
 cards[i,0], cards[i, 1], true,
 $"La carte {cards[i,0]} devrait pouvoir couvrir la carte {cards[i,1]}"
 };
            }
            // Cas où la couleur ne correspond pas
            cards = new Card[,]
            {
 { new Card(2, Card.Suit.HEART, true), new Card(3, Card.Suit.CLUB, true) },
 { new Card(5, Card.Suit.DIAMOND, true), new Card(6, Card.Suit.SPADE, true) },
 { new Card(10, Card.Suit.SPADE, true), new Card(11, Card.Suit.HEART, true) },
 { new Card(7, Card.Suit.CLUB, true), new Card(8, Card.Suit.DIAMOND, true) },
            };
            for (int i = 0; i < cards.GetLength(0); i++)
            {
                yield return new object[]
                {
 cards[i, 0], cards[i, 1], false,
 $"La carte {cards[i, 0]} ne peut couvrir la carte {cards[i, 1]} à cause de la couleur"
                };
            }
            // Cas où la valeur ne correspond pas
            cards = new Card[,]
            {
 { new Card(2, Card.Suit.HEART, true), new Card(2, Card.Suit.HEART, true) },
 { new Card(5, Card.Suit.DIAMOND, true), new Card(4, Card.Suit.DIAMOND, true) },
 { new Card(10, Card.Suit.SPADE, true), new Card(8, Card.Suit.SPADE, true) },
 { new Card(7, Card.Suit.CLUB, true), new Card(6, Card.Suit.CLUB, true) },
            };
            for (int i = 0; i < cards.GetLength(0); i++)
            {
                yield return new object[]
                {
 cards[i, 0], cards[i, 1], false,
 $"La carte {cards[i, 0]} ne peut couvrir la carte {cards[i, 1]} à cause de la valeur"
                };
            }
        }
        [TestMethod]
        public void TestEncodeDecode()
        {
            // On teste toutes les cartes !
            for (int i = 1; i <= 52; i++)
            {
                char encodage = (char)(' ' + i);
                Card c = Card.Decode(encodage);
                Assert.AreEqual(encodage, c.Encode(),
                $"La création de {c} à partir du code {encodage} pour i = {i} donne un encodage de {c.Encode()}"
                );
            }

        }

    }
}