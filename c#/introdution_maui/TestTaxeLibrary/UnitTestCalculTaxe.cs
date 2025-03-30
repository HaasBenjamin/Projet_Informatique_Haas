using TaxeLibrary;

namespace TestTaxeLib
{
    [TestClass]
    public class UnitTestCalculTaxe
    {
        private static Random RND = new Random();
        private double precision;
        private double precisionTaux;
        private bool arrondi = false;

        [TestInitialize]
        public void Initialize()
        {
            CalculTaxe calculTaxe = new CalculTaxe();
            precision = arrondi ? 0.001 : 1e-10;
            precisionTaux = arrondi ? 0.00001 : 1e-10;
        }

        private double ArrondiPrix(double prix)
        {
            return arrondi ? Math.Round(prix, 2) : prix;
        }

        private double ArrondiTaux(double taux)
        {
            return arrondi ? Math.Round(taux, 4) : taux;
        }

        [TestMethod]
        public void TestPrixHT_Taxe()
        {
            CalculTaxe cTaxe = new CalculTaxe();

            Assert.IsTrue(Math.Abs(cTaxe.PrixHT) < precision, $"Le prix TTC {cTaxe.PrixHT} par défaut devrait être initialisé à 0");

            // Tests aléatoires
            for (int _ = 0; _ < 10;  _++)
            {
                double tauxTaxe = RND.NextDouble();

                // Enregistrement du taux de la taxe
                cTaxe.TauxTaxe = tauxTaxe;
                tauxTaxe = ArrondiTaux(tauxTaxe);
                Assert.IsTrue(Math.Abs(cTaxe.TauxTaxe - tauxTaxe) < precisionTaux, $"Le taux de taxe enregistré devrait être de {tauxTaxe} au lieu de {cTaxe.TauxTaxe}.");

                for (int __ = 0; __ < 100; ++__)
                {
                    // Modification du prix HT
                    double prixHT = RND.NextDouble() * 1000.0;
                    cTaxe.PrixHT = prixHT;
                    prixHT = ArrondiPrix(prixHT);
                    Assert.IsTrue(Math.Abs(cTaxe.PrixHT - prixHT) < precision, $"Le prix HT enregistré devrait être de {prixHT} au lieu de {cTaxe.PrixHT}.");

                    // Calcul du prix TTC
                    double taxe = ArrondiPrix(prixHT * tauxTaxe);
                    Assert.IsTrue(Math.Abs(cTaxe.Taxe - taxe) < precision, $"La taxe pour un taux de taxe de {tauxTaxe} et un prix HT de {prixHT} devrait être de {taxe} au lieu de {cTaxe.Taxe}.");
                    double prixTTC = prixHT + taxe;
                    Assert.IsTrue(Math.Abs(cTaxe.PrixTTC - prixTTC) < precision, $"Le prix TTC {cTaxe.PrixTTC} devrait être égal à {prixTTC} pour un taux de taxe de {tauxTaxe} et un prix HT de {prixHT}");
                }
            }
        }

        [TestMethod]
        public void TestPrixTTC_Taxe()
        {
            CalculTaxe cTaxe = new CalculTaxe();

            Assert.IsTrue(Math.Abs(cTaxe.PrixTTC) < precision, $"Le prix HT {cTaxe.PrixTTC} par défaut devrait être initialisé à 0");

            // Tests aléatoires
            for (int _ = 0; _ < 10; _++)
            {
                double tauxTaxe = RND.NextDouble();
                // Enregistrement du taux de la taxe
                cTaxe.TauxTaxe = tauxTaxe;
                tauxTaxe = ArrondiTaux(tauxTaxe);
                Assert.IsTrue(Math.Abs(cTaxe.TauxTaxe - tauxTaxe) < precisionTaux, $"Le taux de taxe enregistré devrait être de {tauxTaxe} au lieu de {cTaxe.TauxTaxe}.");

                for (int __ = 0; __ < 100; ++__)
                {

                    // Modification du prix TTC
                    double prixTTC = RND.NextDouble() * 1000.0;
                    cTaxe.PrixTTC = prixTTC;
                    prixTTC = ArrondiPrix(prixTTC);
                    Assert.IsTrue(Math.Abs(cTaxe.PrixTTC - prixTTC) < precision, $"Le prix HT enregistré devrait être de {prixTTC} au lieu de {cTaxe.PrixTTC}.");

                    // Calcul du prix HT
                    double taxe = ArrondiPrix(prixTTC * tauxTaxe / (1.0 + tauxTaxe));
                    Assert.IsTrue(Math.Abs(cTaxe.Taxe - taxe) < precision, $"La taxe pour un taux de taxe de {tauxTaxe} et un prix TTC de {prixTTC} devrait être de {taxe} au lieu de {cTaxe.Taxe}.");
                    double prixHT = prixTTC - taxe;
                    Assert.IsTrue(Math.Abs(cTaxe.PrixHT - prixHT) < precision, $"Le prix TTC {cTaxe.PrixHT} devrait être égal à {prixHT} pour un taux de taxe de {tauxTaxe} et un prix TTC de {prixTTC}");
                }
            }
        }

        [TestMethod]
        public void TestTauxTaxe()
        {
            CalculTaxe cTaxe = new CalculTaxe();

            Assert.IsTrue(Math.Abs(cTaxe.TauxTaxe - 0.2) < precisionTaux, $"Le taux de la taxe {cTaxe.TauxTaxe} par défaut devrait être initialisé à 0.2");

            // Tests aléatoires
            for (int _ = 0; _ < 10; _++)
            {
                // Enregistrement du prix HT
                double prixHT = RND.NextDouble() * 1000.0;
                cTaxe.PrixHT = prixHT;
                prixHT = ArrondiPrix(prixHT);
                Assert.IsTrue(Math.Abs(cTaxe.PrixHT - prixHT) < precision, $"Le prix HT enregistré devrait être de {prixHT} au lieu de {cTaxe.PrixHT}.");

                for (int __ = 0; __ < 100; __++)
                {
                    double tauxTaxe = RND.NextDouble();

                    // Enregistrement du taux de la taxe
                    cTaxe.TauxTaxe = tauxTaxe;
                    tauxTaxe = ArrondiTaux(tauxTaxe);
                    Assert.IsTrue(Math.Abs(cTaxe.TauxTaxe - tauxTaxe) < precisionTaux, $"Le taux de taxe enregistré devrait être de {tauxTaxe} au lieu de {cTaxe.TauxTaxe}.");

                    // Le prix HT ne doit pas être modifié
                    Assert.IsTrue(Math.Abs(cTaxe.PrixHT - prixHT) < precision, $"Le prix HT préalable {prixHT} ne doit pas être modifié {cTaxe.PrixHT}.");

                    // Calcul du prix TTC
                    double taxe = ArrondiPrix(prixHT * tauxTaxe);
                    Assert.IsTrue(Math.Abs(cTaxe.Taxe - taxe) < precision, $"La taxe pour un taux de taxe de {tauxTaxe} et un prix HT de {prixHT} devrait être de {taxe} au lieu de {cTaxe.Taxe}.");
                    double prixTTC = prixHT + taxe;
                    Assert.IsTrue(Math.Abs(cTaxe.PrixTTC - prixTTC) < precision, $"Le prix TTC {cTaxe.PrixTTC} devrait être égal à {prixTTC} pour un taux de taxe de {tauxTaxe} et un prix HT de {prixHT}");
                }
            }

        }
    }
}