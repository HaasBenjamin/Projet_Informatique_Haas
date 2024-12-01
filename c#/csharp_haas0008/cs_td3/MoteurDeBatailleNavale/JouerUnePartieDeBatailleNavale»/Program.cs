using JouerUnePartieDeBatailleNavale_;
using MoteurDeBatailleNavale;

static void Main(string[] args)
{
    GestionnaireDesScores gest = new GestionnaireDesScores();
    // gest.InitialisationAléatoireDeScores();
    Console.WriteLine("Bataille navale");
    Console.WriteLine("Bonjour joueur 1 ");
    UnJoueurRobotPasTropBête joueur1 = new
   UnJoueurRobotPasTropBête("joueur robot");
    Console.WriteLine("Bonjour joueur 2 ");
    UnJoueurRobotPasTropBête joueur2 = new
   UnJoueurRobotPasTropBête("joueur robot2");
    PartieDeBatailleNavale partie = new PartieDeBatailleNavale(joueur1,
   joueur2);
    bool nouvellePartie;
    do
    { 
        
        partie.ChoisirLesRôlesDeDépartDesJoueurs();
        Console.WriteLine("Le joueur {0} est le premier attaquant",partie.Attaquant.Pseudo);
        gest.ChargerLesScoresPrécédents();
        List<Score> TousLesScores = gest.TousLesScores;
        /*Console.WriteLine("Meilleur Score version 1: ");
        Console.WriteLine(gest.MeilleurScoreDeTousLesTemps_V1().AffichagePropre());
        Console.WriteLine("Meilleur Score version 2: ");
        Console.WriteLine(gest.MeilleurScoreDeTousLesTemps_V2.AffichagePropre());*/
        Console.WriteLine("Meilleur Score version 3: ");
        Console.WriteLine(gest.MeilleurScoreDeTousLesTemps_V3.AffichagePropre());
        /*Console.WriteLine("10 derniers scores : ");
        for (int i = -10; i < 0; i++)
        {
            Console.WriteLine(TousLesScores[TousLesScores.Count+i].AffichagePropre());
        }*/
        partie.PréparerLaBataille();
        Console.WriteLine("La partie commence maintenant");
        
        partie.JouerLaPartie();
        Console.WriteLine("Nouvelle partie ? (O/N) :");
        ConsoleKeyInfo keyinfo = Console.ReadKey();
        if (keyinfo.KeyChar == 'O' || keyinfo.KeyChar == 'o')
            nouvellePartie = true;
        else
            nouvellePartie = false;
    }
    while (nouvellePartie);
}

Main(args);
