# GrilleDemineur.py

from Model.Cellule import *
from Model.Coordonnee import *
from random import shuffle, randint
from itertools import filterfalse


# Méthode gérant la grille du démineur
# La grille d'un démineur est un tableau 2D régulier (rectangulaire)
#
# Il s'agira d'une liste de liste


def type_grille_demineur(grille: list) -> bool:
    """
    Détermine si le paramètre représente une grille d'un démineur.

    :param grille: objet à tester
    :return: `True` s'il peut s'agit d'une grille de démineur, `False` sinon
    """
    if type(grille) != list:
        return False
    # Récupération du nombre de lignes
    nl = len(grille)
    # Il faut que la grille comporte au moins une ligne
    if nl == 0:
        return False
    nc = len(grille[0])
    if nc == 0:
        return False
    return next(filterfalse(lambda line: type(line) == list and len(line) == nc
                            and next(filterfalse(type_cellule, line), True) is True, grille), True) is True
    # Tableau régulier
    # nc = None
    # for line in grille:
    #     if type(line) != list:
    #         return False
    #     if nc is None:
    #         nc = len(line)
    #         # Il faut que la grille comporte au moins une colonne
    #         if nc == 0:
    #             return False
    #     elif nc != len(line):
    #         return False
    #     # Test des cellules de la ligne
    #     if not next(filterfalse(type_cellule, line), True):
    #         return False
    # for cell in line:
    #     if not type_cellule(cell):
    #         return False
    # return True

def construireGrilleDemineur(nbligne:int,nbcol:int)->list:
    '''créer une grille de nbligne et nbcol sous forme de liste de liste'''
    if type(nbligne)!=int or type(nbcol)!=int:
        raise TypeError(f'construireGrilleDemineur : Le nombre de lignes {nbligne} ou de colonnes {nbcol} n’est pas un entier.')
    elif nbligne<=0 or nbcol<=0:
        raise ValueError(f'construireGrilleDemineur : Le nombre de lignes {nbligne} ou de colonnes {nbcol} est négatif ou nul. ')
    else:
        grille = []
        for ligne in range(nbligne):
            lg = []
            for colonne in range(nbcol):
                lg.append(construireCellule())
            grille.append(lg)
        return grille

def getNbLignesGrilleDemineur(grille:list)->int:
    '''reçoit en paramètre une grille et renvoie son nombre de ligne'''
    if not(type_grille_demineur(grille)):
        raise TypeError('getNbLignesGrilleDemineur : Le paramètre n’est pas une grille')
    else:
        return len(grille)

def getNbColonnesGrilleDemineur(grille:list)->int:
    '''reçoit en paramètre une grille et renvoie son nombre de ligne'''
    if not(type_grille_demineur(grille)):
        raise TypeError('getNbColonnesGrilleDemineur : Le paramètre n’est pas une grille')
    else:
        return len(grille[0])

def isCoordonneeCorrecte(grille:list,coord:tuple)->bool:
    '''reçoit une grille et des coordonnées et renvoie true si les coordonnées appartiennent à la grille false sinon'''
    if not type_grille_demineur(grille) or type(coord)!=tuple or not(type_grille_demineur(grille)) or type(coord[0])!=int or type(coord[1])!=int:
        raise TypeError(' isCoordonneeCorrecte : un des paramètres n’est pas du bon type.')
    res=True
    if coord[0]<0 or coord[0]>=getNbLignesGrilleDemineur(grille) or coord[1]<0 or coord[1]>=getNbColonnesGrilleDemineur(grille):
        res=False
    return res

def getCelluleGrilleDemineur(grille:list,coord:tuple)->dict:
    '''renvoie la cellule correspondant aux coordonnées'''
    if not type_grille_demineur(grille) or type(coord)!=tuple or not(type_grille_demineur(grille)) or type(coord[0])!=int or type(coord[1])!=int:
        raise TypeError('getCelluleGrilleDemineur : un des paramètres n’est pas du bon type')
    elif not(isCoordonneeCorrecte(grille,coord)):
        raise IndexError('getCelluleGrilleDemineur : coordonnée non contenue dans la grille')
    return grille[coord[0]][coord[1]]


def getContenuGrilleDemineur(grille:list,coord:tuple)->int:
    '''renvoie le contenu de la cellule de coordonnée coord'''
    return getContenuCellule(getCelluleGrilleDemineur(grille,coord))

def setContenuGrilleDemineur(grille:list,coord:tuple,contenu:int)->None:
    '''modifie le contenu de la cellule de coordonnée coord avec contenu'''
    setContenuCellule(getCelluleGrilleDemineur(grille,coord),contenu)
    return None

def isVisibleGrilleDemineur(grille:list,coord:tuple)->bool:
    '''renvoie true si la cellule de coordonnée coord est visible false sinon'''
    return isVisibleCellule(getCelluleGrilleDemineur(grille,coord))

def setVisibleGrilleDemineur(grille:list,coord:tuple,visible:bool)->None:
    '''modifie la visibilité de la cellule de coordonnée coord avec visible'''
    setVisibleCellule(getCelluleGrilleDemineur(grille,coord),visible)
    return None

def contientMineGrilleDemineur(grille:list,coord:tuple):
    '''return true si la cellule de coordonnée coord contient une mine false sinon'''
    return contientMineCellule(getCelluleGrilleDemineur(grille,coord))

def getCoordonneeVoisinsGrilleDemineur(grille:list,coord:tuple)->list:
    '''renvoie les coordonnées des cases voisins'''
    if not type_grille_demineur(grille) or type(coord)!=tuple or not(type_grille_demineur(grille)) or type(coord[0])!=int or type(coord[1])!=int:
        raise TypeError('getCoordonneeVoisinsGrilleDemineur : un des paramètres n’est pas du bon type')
    if not isCoordonneeCorrecte(grille,coord):
        raise IndexError('getCoordonneeVoisinsGrilleDemineur : la coordonnée n’est pas dans la grille')
    liste_cooor=[]
    autour=[(-1,-1),(-1,0),(-1,1),(0,-1),(0,1),(1,-1),(1,0),(1,1)]
    for i in range(len(autour)):
        coord_tmp=(coord[0]+autour[i][0],coord[1]+autour[i][1])
        if isCoordonneeCorrecte(grille,coord_tmp):
            liste_cooor.append(coord_tmp)
    return liste_cooor


def placerMinesGrilleDemineur(grille : list, nb : int, coord : tuple) -> None:
    """Place nb bombe dans la grille"""
    lignes = getNbLignesGrilleDemineur(grille)
    colonnes = getNbColonnesGrilleDemineur(grille)
    if nb < 0 or nb >= lignes * colonnes:
        raise ValueError("placerMinesGrilleDemineur : Nombre de bombes à placer incorrect")
    elif not isCoordonneeCorrecte(grille,coord):
        raise IndexError("placerMinesGrilleDemineur : la coordonnée n’est pas dans la grille.")
    else:
        libre=[]
        for i in range(len(grille)):
            for j in range(len(grille[i])):
                libre.append((i,j))
        libre.remove(coord)
        shuffle(libre)
        while nb != 0:
            ligne = libre[0][0]
            col = libre[0][1]
            if not contientMineGrilleDemineur(grille,(ligne,col)):
                setContenuGrilleDemineur(grille,(ligne,col),const.ID_MINE)
                nb -= 1
            del libre[0]
    compterMinesVoisinesGrilleDemineur(grille)
    return None



def compterMinesVoisinesGrilleDemineur(grille:list)->None:
    '''Pour chaque cellule ne comportant pas une mine remplace son contenu par le nombre de bombe au alentours'''
    if not type_grille_demineur(grille):
        raise ValueError('getNbMinesGrilleDemineur : le paramètre n’est pas une grille.')
    for ligne in range(len(grille)):
        for col in range(len(grille[ligne])):
            if not(contientMineGrilleDemineur(grille,(ligne,col))):
                nombre_mine=0
                for elt in getCoordonneeVoisinsGrilleDemineur(grille,(ligne,col)):
                    if contientMineGrilleDemineur(grille,elt):
                        nombre_mine+=1
                setContenuGrilleDemineur(grille,(ligne,col),nombre_mine)
    return None

def getNbMinesGrilleDemineur(grille:list)->int:
    '''retourne le nombre de bombe contenu dans la grille'''
    if not type_grille_demineur(grille):
        raise ValueError('getNbMinesGrilleDemineur : le paramètre n’est pas une grille')
    bombe=0
    for i in range(len(grille)):
        for j in range(len(grille[i])):
            if contientMineGrilleDemineur(grille,(i,j)):
                bombe+=1
    return bombe

def getAnnotationGrilleDemineur(grille:list,coord:tuple)->str:
    '''retourne l'annotation de la cellule de coordonnée coord'''
    return getAnnotationCellule(getCelluleGrilleDemineur(grille,coord))

def getMinesRestantesGrilleDemineur(grille:list)->int:
    '''retourne le nombre de mines restantes'''
    drapeau=0
    for ligne in grille:
        for col in ligne:
            if getAnnotationCellule(col)==const.FLAG:
                drapeau+=1

    return getNbMinesGrilleDemineur(grille)-drapeau

def gagneGrilleDemineur(grille:list)->bool:
    '''retourne true si la partie est terminée false sinon'''
    gagne=True
    i=0
    j=0
    while gagne and i < getNbLignesGrilleDemineur(grille):
        while j < getNbColonnesGrilleDemineur(grille) and gagne:
            cell=getCelluleGrilleDemineur(grille,(i,j))
            if ((isVisibleCellule(cell) and contientMineCellule(cell)) and getAnnotationCellule(cell)!=const.FLAG) or (not(isVisibleCellule(cell)) and not(contientMineCellule(cell))) :
                gagne=False
            j+=1
        i+=1
        j=0
    return gagne

def perduGrilleDemineur(grille:list)->bool:
    '''retourne true si la partie est perdu false sinon'''
    perdu = False
    i = 0
    j = 0
    while not perdu and i < getNbLignesGrilleDemineur(grille):
        while j < getNbColonnesGrilleDemineur(grille) and not perdu:
            cell = getCelluleGrilleDemineur(grille, (i, j))
            if isVisibleCellule(cell) and contientMineCellule(cell):
                perdu = True
            j += 1
        i += 1
        j = 0
    return perdu


def reinitialiserGrilleDemineur(grille:list)->None:
    '''reinitialise toutes les cellules de la grille'''
    for i in range(len(grille)):
        for j in range(len(grille[i])):
            reinitialiserCellule(getCelluleGrilleDemineur(grille,(i,j)))
    return None

def decouvrirGrilleDemineur(grille:list,coord:tuple)->set:
    '''permet de découvrir les cases vides'''
    decouvrir=set()
    setVisibleGrilleDemineur(grille, coord, True)
    decouvrir.add(coord)
    coordonnee=[coord]
    while coordonnee != []:
        coord=coordonnee[0]
        del coordonnee[0]
        if getContenuGrilleDemineur(grille, coord) == 0:
            voisin = getCoordonneeVoisinsGrilleDemineur(grille, coord)
            for elt in voisin:
                if not isVisibleGrilleDemineur(grille, elt):
                    setVisibleGrilleDemineur(grille, elt, True)
                    decouvrir.add(elt)
                    print('Decouverte de la cellule',elt)
                    if getContenuGrilleDemineur(grille, elt) == 0:
                        coordonnee.append(elt)
    return decouvrir

def simplifierGrilleDemineur(grille:list,coord:tuple)->set:
    '''découvre les cases evidentes'''
    decouvrir=set()
    coordonnee = [coord]
    while coordonnee != []:
        coord = coordonnee[0]
        del coordonnee[0]
        if isVisibleGrilleDemineur(grille,coord):
            cont=getContenuGrilleDemineur(grille,coord)
            drapeau=0
            voisins=getCoordonneeVoisinsGrilleDemineur(grille,coord)
            for elt in voisins:
                if getAnnotationGrilleDemineur(grille,elt) == const.FLAG:
                    drapeau+=1
            if drapeau == cont :
                for elt in voisins:
                    if getAnnotationGrilleDemineur(grille, elt) != const.FLAG:
                        if elt not in decouvrir and not isVisibleGrilleDemineur(grille,elt):
                            setVisibleGrilleDemineur(grille,elt,True)
                            decouvrir.add(elt)
                            coordonnee.append(elt)
                            print('Rendu visible de la cellule',elt)
    return decouvrir

def isResolu(grille:list,coord:tuple)->None:
    '''modifie le resolu si la cellule est resolu'''
    voisins=getCoordonneeVoisinsGrilleDemineur(grille,coord)
    resol=True
    for elt in voisins:
        if not isVisibleGrilleDemineur(grille,elt) and getAnnotationGrilleDemineur(grille,elt)!=const.FLAG:
            resol=False
    getCelluleGrilleDemineur(grille,coord)[const.RESOLU]=resol
    return None


def ajouterFlagsGrilleDemineur(grille:list,coord:tuple)->set:
    '''retourne les cases sur lequel ajouter un drapeau'''
    ajouter=set()
    cont=getContenuGrilleDemineur(grille,coord)
    voisins=getCoordonneeVoisinsGrilleDemineur(grille,coord)
    non_decouv=0
    place=[]
    for elt in voisins:
        if not isVisibleGrilleDemineur(grille,elt):
            non_decouv+=1
            place.append(elt)
    if cont==non_decouv:
        for elt in place:
            if getAnnotationGrilleDemineur(grille,elt)!=const.FLAG:
                ajouter.add(elt)
                changeAnnotationCellule(getCelluleGrilleDemineur(grille,elt))
                print("Ajout d'un drapeau pour la cellule ",elt)
    return ajouter

def simplifierToutGrilleDemineur(grille:list)->tuple:
    '''simplifie toute la grille au maximum'''
    change_visi=set()
    change_flag=set()
    i=0
    j=0
    any_modif=True
    while any_modif and not gagneGrilleDemineur(grille):
        any_modif=False
        print('(Re)départ de (0,0)')
        for i in range(len(grille)):
            for j in range(len(grille[0])):
                isResolu(grille,(i,j))
                if isVisibleGrilleDemineur(grille,(i,j)) and (getCelluleGrilleDemineur(grille,(i,j))[const.RESOLU]==False) and not contientMineGrilleDemineur(grille,(i,j)) :
                    visi_tmp=simplifierGrilleDemineur(grille,(i,j))
                    flag_tmp=ajouterFlagsGrilleDemineur(grille,(i,j))
                    if len(visi_tmp)>0:
                        any_modif = True
                        change_visi=change_visi.union(visi_tmp)
                        isResolu(grille, (i, j))
                    if len(flag_tmp)>0:
                        any_modif = True
                        change_flag=change_flag.union(flag_tmp)
                        isResolu(grille,(i,j))
    return (change_visi,change_flag)

