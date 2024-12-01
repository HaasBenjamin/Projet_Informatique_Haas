namespace MoteurDeBatailleNavale
{
    public class CoordonnéesDeBatailleNavale
    {
        public static readonly char[]  colposs =   { 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J' };
        public static readonly byte[] ligneposs = { 1,2,3,4,5,6,7,8,9,10 };
       

        public char Colonne
        {
            get;
        }

        public byte Ligne
        {
            get;
        }

        public CoordonnéesDeBatailleNavale(char colonne, byte ligne)
        {

            bool col = false;
            bool lig = false;

            foreach (char elt in CoordonnéesDeBatailleNavale.colposs)
            {
                if (elt == colonne)
                {
                    col = true;
                   break;
                  //  goto suivant;
                }
            }

//         suivant:

            foreach (byte elt in CoordonnéesDeBatailleNavale.ligneposs)
            {
                if (elt == ligne)
                {
                    lig = true;
                    break;
                }
            }



            if (!col || !lig)
            {
                throw new ArgumentOutOfRangeException("Colonne ou ligne invalide");
            }
            Colonne = colonne;
            Ligne = ligne;
        }

        private CoordonnéesDeBatailleNavale()
        {
        }

        public override bool Equals(object? obj)
        {

            if (obj is CoordonnéesDeBatailleNavale coord && obj != null  )
            {
                return ((Colonne == coord.Colonne) && (Ligne == coord.Ligne));
            }
            return false;
        }
    }
}