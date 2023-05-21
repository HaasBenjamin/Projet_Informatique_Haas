from random import *
import time
from pygame_Haas_Lawson import * # à mettre en commentaire pour empecher le lancement du rendu graphique

'''
info pygame :
il y a 8 niveaux
touches importantes :
q ou a selon le clavier/pc : permet de quitter la fenetre
espace : permet de sauter un niveau
clic : permet de sauter les transitions

informations supplémentaires:
la fenêtre pygame peut mettre du temps à charger selon le pc et parfois necessite un clic sur l'icone pour ouvrir
les betes se déplacent aléatoirement quand la distance les séparant du joueur >2
et se déplacent vers le joueur quand la distance est <=2 ( cette règle peut être compromise lors de la destruction d'un mur car le labyrinthe n'est plus parfait donc la bete peut avoir un déplacement <<insensé>>

'''

class Maze:
    """
    Classe Labyrinthe
    Représentation sous forme de graphe non-orienté
    dont chaque sommet est une cellule (un tuple (l,c))
    et dont la structure est représentée par un dictionnaire
      - clés : sommets
      - valeurs : ensemble des sommets voisins accessibles
    """
    def __init__(self, height, width,empty):
        """
        Constructeur d'un labyrinthe de height cellules de haut
        et de width cellules de large
        Les voisinages sont initialisés à des ensembles vides
        Remarque : dans le labyrinthe créé, chaque cellule est complètement emmurée
        """
        self.height    = height
        self.width     = width
        if not empty:
            self.neighbors = {(i,j): set() for i in range(height) for j in range (width)}
        else :
            self.neighbors={}
            coord=[(-1,0),(0,-1),(1,0),(0,1)]
            for i in range(height) :
                for j in range (width):
                    ensemble=set()
                    for elt in coord:
                        coord_vois=(i+elt[0],j+elt[1])
                        if coord_vois[0]>=0 and coord_vois[0]<width and coord_vois[1]>=0 and coord_vois[1]<height:
                            ensemble.add(coord_vois)
                    self.neighbors[(i,j)]=ensemble



    def info(self):
        """
        **NE PAS MODIFIER CETTE MÉTHODE**
        Affichage des attributs d'un objet 'Maze' (fonction utile pour deboguer)
        Retour:
            chaîne (string): description textuelle des attributs de l'objet
        """
        txt = "**Informations sur le labyrinthe**\n"
        txt += f"- Dimensions de la grille : {self.height} x {self.width}\n"
        txt += "- Voisinages :\n"
        txt += str(self.neighbors)+"\n"
        valid = True
        for c1 in {(i, j) for i in range(self.height) for j in range(self.width)}:
            for c2 in self.neighbors[c1]:
                if c1 not in self.neighbors[c2]:
                    valid = False
                    break
            else:
                continue
            break
        txt += "- Structure cohérente\n" if valid else f"- Structure incohérente : {c1} X {c2}\n"
        return txt

    def __str__(self):
        """
        **NE PAS MODIFIER CETTE MÉTHODE**
        Représentation textuelle d'un objet Maze (en utilisant des caractères ascii)
        Retour:
             chaîne (str) : chaîne de caractères représentant le labyrinthe
        """
        txt = ""
        # Première ligne
        txt += "┏"
        for j in range(self.width-1):
            txt += "━━━┳"
        txt += "━━━┓\n"
        txt += "┃"
        for j in range(self.width-1):
            txt += "   ┃" if (0,j+1) not in self.neighbors[(0,j)] else "    "
        txt += "   ┃\n"
        # Lignes normales
        for i in range(self.height-1):
            txt += "┣"
            for j in range(self.width-1):
                txt += "━━━╋" if (i+1,j) not in self.neighbors[(i,j)] else "   ╋"
            txt += "━━━┫\n" if (i+1,self.width-1) not in self.neighbors[(i,self.width-1)] else "   ┫\n"
            txt += "┃"
            for j in range(self.width):
                txt += "   ┃" if (i+1,j+1) not in self.neighbors[(i+1,j)] else "    "
            txt += "\n"
        # Bas du tableau
        txt += "┗"
        for i in range(self.width-1):
            txt += "━━━┻"
        txt += "━━━┛\n"

        return txt
    def add_wall(self, c1, c2):
    # Facultatif : on teste si les sommets sont bien dans le labyrinthe
        assert 0 <= c1[0] < self.height and \
        0 <= c1[1] < self.width and \
        0 <= c2[0] < self.height and \
        0 <= c2[1] < self.width, \
        f"Erreur lors de l'ajout d'un mur entre {c1} et {c2} : les coordonnées de sont pas compatibles avec les dimensions du labyrinthe"
    # Ajout du mur
        if c2 in self.neighbors[c1]:      # Si c2 est dans les voisines de c1
            self.neighbors[c1].remove(c2) # on le retire
        if c1 in self.neighbors[c2]:      # Si c3 est dans les voisines de c2
            self.neighbors[c2].remove(c1) # on le retire

    def remove_wall(self, c1, c2):
    # Facultatif : on teste si les sommets sont bien dans le labyrinthe
        assert 0 <= c1[0] < self.height and \
        0 <= c1[1] < self.width and \
        0 <= c2[0] < self.height and \
        0 <= c2[1] < self.width, \
        f"Erreur lors de la suppresion du  mur entre {c1} et {c2} : les coordonnées de sont pas compatibles avec les dimensions du labyrinthe"
    # Ajout du mur
        if c2 not in self.neighbors[c1]:  # Si c2 n'est pas dans les voisines de c1
            self.neighbors[c1].add(c2)    # on le rajoute
        if c1 not in self.neighbors[c2]:      # Si c3 n'est pas dans les voisines de c2
            self.neighbors[c2].add(c1) # on le rajoute

    def get_walls(self):
        '''retourne l'ensemble des murs du labyrinthe sous forme d'une liste de tuple '''
        vide={}
        liste_mur=[]
        coord=[(-1,0),(0,-1),(1,0),(0,1)] # coordonnées des 4 cellules voisines par rapport à la case
        for i in range(self.height) :
            for j in range (self.width):
                ensemble=set()
                for elt in coord:
                    coord_vois=(i+elt[0],j+elt[1])
                    if coord_vois[0]>=0 and coord_vois[0]<self.width and coord_vois[1]>=0 and coord_vois[1]<self.height: # si la coord est dans le labyrinthe
                        ensemble.add(coord_vois)
                vide[(i,j)]=ensemble
        for cle in vide.keys():
            tmp=[]
            for val in vide[cle]:
                if val not in self.neighbors[cle]: # tous les éléments qui sont dans un labyrinthe complet mais pas dans celui actuel
                    tmp.append(val)
            for elt in tmp:
                if [elt,cle] not in liste_mur: # on verifie que le mur n'a pas deja été ajouté
                    liste_mur.append([cle,elt])
        return liste_mur


    def fill(self):
        '''ajoute tous les murs possibles'''
        for cle in self.neighbors.keys():
            self.neighbors[cle]=set() # on réinitialise toutes les cases avec un ensemble vide
        return None

    def empty(self):
        '''retire tous les murs '''
        self.neighbors={}
        coord=[(-1,0),(0,-1),(1,0),(0,1)] # coordonnées des 4 cellules voisines par rapport à la case
        for i in range(self.height) :
            for j in range (self.width):
                ensemble=set()
                for elt in coord:
                    coord_vois=(i+elt[0],j+elt[1])
                    if coord_vois[0]>=0 and coord_vois[0]<self.width and coord_vois[1]>=0 and coord_vois[1]<self.height: # si la coordonnée est dans le labyrinthe
                        ensemble.add(coord_vois)
                self.neighbors[(i,j)]=ensemble
        return None

    def get_contiguous_cells(self,c):
        '''renvoie la liste des cellules voisines'''
        coord=[(-1,0),(0,-1),(1,0),(0,1)] # coordonnées des 4 cellules voisines par rapport à la case
        voisins=[]
        for elt in coord:
                    coord_vois=(c[0]+elt[0],c[1]+elt[1])
                    if coord_vois[0]>=0 and coord_vois[0]<self.width and coord_vois[1]>=0 and coord_vois[1]<self.height: # si la coordonnée est dans le labyrinthe
                        voisins.append(coord_vois)
        return voisins

    def get_reachable_cells(self,c):
        '''renvoie la liste des cellules voisines accessibles'''
        coord=[(-1,0),(0,-1),(1,0),(0,1)] # coordonnées des 4 cellules voisines par rapport à la case
        voisins=[]
        for elt in coord:
                    coord_vois=(c[0]+elt[0],c[1]+elt[1])
                    if coord_vois[0]>=0 and coord_vois[0]<self.width and coord_vois[1]>=0 and coord_vois[1]<self.height and coord_vois  in self.neighbors[c]: # si la coordonnée est dans le labyrinthe et dans neighbors
                        voisins.append(coord_vois)
        return voisins


    @classmethod
    def gen_btree(self,w,h):
        '''Algorythme de génération par arbre binaire'''
        labyr=Maze(h,w,False)
        for i in range(h) :
                for j in range (w):
                    voisins=labyr.get_contiguous_cells((i,j))    # cellules voisines
                    possible=labyr.get_reachable_cells((i,j))     # cellules atteignables

                    est =(i,j+1) # coordonnées de la cellule est
                    sud = (i+1,j) # coordonnées de la cellule sud
                    if est in voisins and sud not in voisins and est not in possible :  # cas ou le mur est existe et est présent mais pas le sud
                        labyr.remove_wall((i,j),est)

                    elif est not in voisins and sud  in voisins and sud not in possible: # cas ou le mur sud existe et est présent mais pas le est
                        labyr.remove_wall((i,j),sud)

                    elif est in voisins and sud  in voisins and est not in possible and sud not in possible : # cas aléatoire
                        labyr.remove_wall((i,j),choice([est,sud]))

        return labyr
    @classmethod
    def gen_sidewinder(self,h,w):
        '''génération du labyrinthe par l'algorythme Sidewinder'''
        labyr=Maze(h,w,False)
        for i in range(h-1):
            sequence=[]
            for j in range(w-1):
                sequence.append((i,j))
                pilfa=randint(0,1)
                if pilfa == 0:   # pile on casse le mur est
                    labyr.remove_wall((i,j),(i,j+1))
                else:
                    cell=choice(sequence)
                    labyr.remove_wall(cell,(cell[0]+1,cell[1]))
                    sequence=[]
            sequence.append((i,w-1))
            cellule=choice(sequence)
            labyr.remove_wall(cellule,(cellule[0]+1,cellule[1]))
        for j in range(w-1):
            labyr.remove_wall((h-1,j),(h-1,j+1)) # suppréssion derniere ligne
        return labyr

    @classmethod
    def gen_fusion(self,h,w):
        '''génération de labyrinthe par fusion '''
        labyr=Maze(h,w,False)
        numlabel=1
        label={}
        for i in range(h):
            for j in range(w):
                label[(i,j)]=numlabel  # ajout d'un label pour chaque case
                numlabel+=1
        murs=labyr.get_walls()
        shuffle(murs)
        for elt in murs:
            if label[elt[0]]!=label[elt[1]] :  # label différent
                labyr.remove_wall(elt[0],elt[1])
                labelelt0=label[elt[0]]
                label[elt[0]]=label[elt[1]]
                for place in label.keys():
                    if label[place]==labelelt0: # remplacement de tous les labels identiques à la premiere cellule
                        label[place]=label[elt[1]]
        return labyr

    @classmethod
    def gen_exploration(self,h,w):
        '''Création du labyrinthe sur le principe du parcours en profondeur'''
        labyr=Maze(h,w,False)
        cellules={}
        for i in range(h):
            for j in range(w):
                cellules[(i,j)]=False  # marquage à faux de toutes les cellules
        cellule=(randint(0,h-1),randint(0,w-1))
        cellules[cellule]=True  # marquage cellule aléatoire
        pile=[cellule]
        while pile:
            case=pile.pop() # dépilage
            voisins=labyr.get_contiguous_cells(case)
            voisins_pasv=[]
            for elt in voisins :
                if not cellules[elt]: # pas marque
                    voisins_pasv.append(elt)
            if len(voisins_pasv)>0: # si au moins 1 voisins pas visité
                pile.append(case)
                case1=choice(voisins_pasv)
                labyr.remove_wall(case,case1)
                cellules[case1]=True
                pile.append(case1)
        return labyr



    @classmethod
    def gen_wilson(self,h,w):
        labyr=Maze(h,w,False)
        marque={}
        cell_poss=[]
        for i in range(h):
            for j in range(w):
                cell_poss.append((i,j)) # recupération de toutes les positions
                marque[(i,j)]=False # marquage à false
        cel_act=choice(cell_poss)
        cell_poss.remove(cel_act)
        marque[cel_act]=True # marquage aléatoire d'une case
        while False in marque.values():  # tant que tout n'est pas marque
            cel_act=choice(cell_poss)
            cell_poss.remove(cel_act)
            chemin=[cel_act]
            arrive=False
            while not arrive:  # tant qu'on n'a pas atteint une case marquée
                voisins=labyr.get_contiguous_cells(cel_act)
                cel_act=choice(voisins)
                if cel_act in chemin:
                    ind=chemin.index(cel_act)
                    chemin=chemin[0:ind+1] # on revient au début de la boucle
                else:
                    chemin.append(cel_act)
                    if marque[cel_act]:
                        arrive=True
            for elt in chemin:
                marque[elt]=True
                if elt in cell_poss:
                    cell_poss.remove(elt)  # elles ne peuvent plus etre des points de départ
            for i in range(len(chemin)-1):
                labyr.remove_wall(chemin[i],chemin[i+1])  # on détruit les murs
        return labyr




    def overlay(self, content=None):
        """
    Rendu en mode texte, sur la sortie standard, \
    d'un labyrinthe avec du contenu dans les cellules
    Argument:
        content (dict) : dictionnaire tq content[cell] contient le caractère à afficher au milieu de la cellule
    Retour:
        string
        """
        if content is None:
            content = {(i,j):' ' for i in range(self.height) for j in range(self.width)}
        else:
        # Python >=3.9
        #content = content | {(i, j): ' ' for i in range(
        #    self.height) for j in range(self.width) if (i,j) not in content}
        # Python <3.9
            new_content = {(i, j): ' ' for i in range(self.height) for j in range(self.width) if (i,j) not in content}
            content = {**content, **new_content}
        txt = r""
    # Première ligne
        txt += "┏"
        for j in range(self.width-1):
            txt += "━━━┳"
        txt += "━━━┓\n"
        txt += "┃"
        for j in range(self.width-1):
            txt += " "+content[(0,j)]+" ┃" if (0,j+1) not in self.neighbors[(0,j)] else " "+content[(0,j)]+"  "
        txt += " "+content[(0,self.width-1)]+" ┃\n"
    # Lignes normales
        for i in range(self.height-1):
            txt += "┣"
            for j in range(self.width-1):
                txt += "━━━╋" if (i+1,j) not in self.neighbors[(i,j)] else "   ╋"
            txt += "━━━┫\n" if (i+1,self.width-1) not in self.neighbors[(i,self.width-1)] else "   ┫\n"
            txt += "┃"
            for j in range(self.width):
                txt += " "+content[(i+1,j)]+" ┃" if (i+1,j+1) not in self.neighbors[(i+1,j)] else " "+content[(i+1,j)]+"  "
            txt += "\n"
    # Bas du tableau
        txt += "┗"
        for i in range(self.width-1):
            txt += "━━━┻"
        txt += "━━━┛\n"
        return txt


    def solve_dfs(self,start, stop):
        '''algorithme de  résolution par parcours en profondeur'''
        file=[start]
        marque={}
        j=self.height
        i=self.width
        for h in range(i):
            for k in range(j):
                marque[h,k]=False  # marquage
        marque[start]=True

        predecesseur={start:start}

        trouve=False

        while False in marque.values() and not trouve :  # tant qu'il reste des marquage à faux et que le chemin n'est pas trouve

            c=file.pop(0)  # defilage


            if c == stop:
                trouve=True  # chemin trouve
            else:
                voisins=self.get_reachable_cells(c)
                tmp=[]
                for elt in voisins:
                    if not marque[elt]:
                        marque[elt]=True
                        tmp.append(elt)
                        predecesseur[elt]=c

                file=tmp+file # on parcours en profondeur



        c=stop
        chemin=[]

        while c != start: # on restitue le chemin
            chemin.append(c)
            c=predecesseur[c]

        chemin.append(start)
        chemin.reverse() # on l'inverse
        return chemin


    def solve_bfs(self,start, stop):
        '''algorithme de résolution par parcours en largeur'''
        file=[start]
        marque={}
        j=self.height
        i=self.width
        for h in range(i):
            for k in range(j):
                marque[h,k]=False # marquage
        marque[start]=True

        predecesseur={start:start}

        trouve=False

        while False in marque.values() and not trouve : # tant qu'il reste des marquage à faux et que le chemin n'est pas trouve

            c=file.pop(0)


            if c == stop:
                trouve=True
            else:
                voisins=self.get_reachable_cells(c)

                for elt in voisins:
                    if not marque[elt]:
                        marque[elt]=True
                        file.append(elt) # on parcours en largeur
                        predecesseur[elt]=c



        c=stop
        chemin=[]

        while c != start: #on restitue
            chemin.append(c)
            c=predecesseur[c]

        chemin.append(start)
        chemin.reverse()
        return chemin



    def solve_rhr(self,start, stop):
        '''Resolution algorithme de la main droite '''


        depla=[(0,-1),(1,0),(0,1),(-1,0),(0,-1)] # orientation ordre changement quand on ne tourne pas à droite
        depla_droite = [(-1,0),(0,1),(1,0),(0,-1)] # orientation ordre changement quand on trourne à droite
        position=start
        predecesseur={start:start}
        chemin=[start]
        direction=0
        while position != stop:



            possible=self.get_reachable_cells(position)
            position_face=(position[0]+depla[direction+1][0],position[1]+depla[direction+1][1])
            position_droite=(position[0]+depla[direction][0],position[1]+depla[direction][1])
            if position_droite in possible : # si on peut tourner à droite
                if position_droite not in chemin: # si on va sur une nouvelle case
                    chemin.append(position_droite)
                    if position_droite not in predecesseur.keys(): # s'il n'existe pas deja un prédécesseur
                        predecesseur[position_droite]=position


                position=position_droite
                ind=depla_droite.index(depla[direction])
                if ind <3: # on change l'orientation
                    ind+=1
                    direction=depla.index(depla_droite[ind])
                else:
                    direction=depla.index(depla_droite[0])
            elif position_face in possible : # si on peut aller en face
                if position_face not in chemin: # si on va sur une nouvelle case
                    chemin.append(position_face)
                if position_face not in predecesseur.keys(): # s'il n'existe pas deja un prédécesseur
                    predecesseur[position_face]=position
                position=position_face
            else:

                if direction <3: # on change l'orientation
                    direction+=1
                else:
                    direction=0
        c=stop
        chemin1=[]

        while c != start: # on restitue le chemin
            chemin1.append(c)
            c=predecesseur[c]

        chemin1.append(start)
        chemin1.reverse()

        return chemin1


    def distance_geo(self,c1,c2):
        '''calcule la distance géodésique entre c1 et c2'''
        return len(self.solve_bfs(c1,c2))-1 # on calcul la taille du chemin et on retire le point de depart

    def distance_man(self,c1, c2):
        '''calcule la distance de Manhattan'''
        if c2[1]>=c1[1] and  c2[0]>=c1[0]: # si abscisse et ordonnée plus grand ou égal
            nbcoup= c2[1]-c1[1]+c2[0]-c1[0]

        elif c2[1]<c1[1] and  c2[0]>=c1[0] : #  ordonnée plus grand ou égal
            nbcoup =c1[1]-c2[1]+c2[0]-c1[0]

        elif c2[1]>=c1[1] and  c2[0]<c1[0] : #  abscisse plus grand ou égal
            nbcoup =c2[1]-c1[1]+c1[0]-c2[0]

        elif c2[1]<c1[1] and  c2[0]<c1[0]: # abscisse et ordonnée plus petit
            nbcoup =c1[1]-c2[1]+c1[0]-c2[0]
        return nbcoup


print('test : labyrinthe vide')
labyvide = Maze(4, 4, empty = True)
print(labyvide)

print('test : labyrinthe plein')
labyplein = Maze(4, 4, empty = False)
print(labyplein)


print('test : fill')
labyfill = Maze(5, 5, empty = True)
labyfill.fill()
print(labyfill)

print('test : remove')
labyfill.remove_wall((0, 0), (0, 1))
print(labyfill)


print('test : empty')
labyfill.empty()
labyfill.add_wall((0, 0), (0, 1))
labyfill.add_wall((0, 1), (1, 1))
print(labyfill)


print('test : get walls')
print(labyfill.get_walls())


print('test : get contiguous cells')
print(labyfill.get_contiguous_cells((0,1)))


print('test : get reachable cells')
print(labyfill.get_reachable_cells((0,1)))



print('test : gen btree')
labybtree = Maze.gen_btree(4, 4)
print(labybtree)


print('test : gen sidewinder')
labyside = Maze.gen_sidewinder(4, 4)
print(labyside)

print('test : gen fusion')
labyfus = Maze.gen_fusion(15,15)
print(labyfus)

print('test : gen exploration')
labyexplo = Maze.gen_exploration(15,15)
print(labyexplo)


print('test : gen wilson')
laby = Maze.gen_wilson(12, 12)
print(laby)

print('test : résolution dfs')
laby = Maze.gen_fusion(15, 15)
solution = laby.solve_dfs((0, 0), (14, 14))
str_solution = {c:'*' for c in solution}
str_solution[( 0,  0)] = 'D'
str_solution[(14, 14)] = 'A'
print(laby.overlay(str_solution))


print('test : résolution bfs')
laby = Maze.gen_fusion(15, 15)
solution = laby.solve_bfs((0, 0), (14, 14))
str_solution = {c:'*' for c in solution}
str_solution[( 0,  0)] = 'D'
str_solution[(14, 14)] = 'A'
print(laby.overlay(str_solution))


print('test : résolution main droite')
laby = Maze.gen_fusion(15, 15)
solution = laby.solve_rhr((0, 0), (14, 14))
str_solution = {c:'*' for c in solution}
str_solution[( 0,  0)] = 'D'
str_solution[(14, 14)] = 'A'
print(laby.overlay(str_solution))


print('test : distance géo ')
print(laby.distance_geo((0,0),(14,14)))

print('test : distance manhattan ')
print(laby.distance_man((0,0),(14,14)))










