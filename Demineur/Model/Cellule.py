# Model/Cellule.py
#

from Model.Constantes import *

#
# Modélisation d'une cellule de la grille d'un démineur
#


def type_cellule(cell: dict) -> bool:
    """
    Détermine si le paramètre est une cellule correcte ou non

    :param cell: objet dont on veut tester le type cellule
    :return: True si c'est une cellule, False sinon
    """
    return type(cell) == dict and const.CONTENU in cell and const.VISIBLE in cell \
        and type(cell[const.VISIBLE] == bool) and type(cell[const.CONTENU]) == int \
        and (0 <= cell[const.CONTENU] <= 8 or cell[const.CONTENU] == const.ID_MINE)

def isContenuCorrect(ent):
    '''retoune true si le contenu est correct false sinon'''
    if type(ent)!= int:
        res = False
    else:
        if (ent <0 or ent >8) and ent != const.ID_MINE:
            res=False
        else:
            res=True
    return res

def construireCellule(contenu :int =0,visible : bool =False)->dict:
    '''reçoit en paramètre un contenu et une visibilité et renvoie la cellule correspondante'''
    if not(isContenuCorrect(contenu)):
        raise ValueError(f'construireCellule : le contenu {contenu} n’est pas correct')
    elif type(visible) != bool:
        raise TypeError(f"construireCellule : le second paramètre {type(visible)} n’est pas un booléen ")
    return {const.CONTENU:contenu,const.VISIBLE:visible,const.ANNOTATION:None,const.RESOLU:False}

def getContenuCellule(cell:dict)->int:
    '''reçoit en paramètre une cellule et renvoie son contenu'''
    if not(type_cellule(cell)):
        raise TypeError('getContenuCellule : Le paramètre n’est pas une cellule')
    return cell[const.CONTENU]

def isVisibleCellule(cell:dict)->bool:
    '''reçoit en paramètre une cellule et renvoie sa visibilité'''
    if not(type_cellule(cell)):
        raise TypeError('isVisibleCellule : Le paramètre n’est pas une cellule')
    return cell[const.VISIBLE]

def setContenuCellule(cell:dict,contenu:int)->None:
    '''remplace le contenu de la cellule passée en paramètre par contenu'''
    if type(contenu)!=int:
        raise TypeError('setContenuCellule : Le second paramètre n’est pas un entier')
    if not(isContenuCorrect(contenu)):
        raise ValueError(f'setContenuCellule : la valeur du contenu {contenu} n’est pas correct')
    elif not(type_cellule(cell)):
        raise TypeError('setContenuCellule : Le premier paramètre n’est pas une cellule')
    cell[const.CONTENU]=contenu
    return None


def setVisibleCellule(cell:dict,visible:bool)->None:
    '''remplace la visibilité de la cellule passée en paramètre par visible'''
    if type(visible)!=bool:
        raise TypeError('setVisibleCellule : Le second paramètre n’est pas un booleen')
    elif not(type_cellule(cell)):
        raise TypeError('setVisibleCellule : Le premier paramètre n’est pas une cellule')
    cell[const.VISIBLE]=visible
    return None


def contientMineCellule(cell:dict)->bool:
    '''return true si cell contient une mine false sinon'''
    if not(type_cellule(cell)):
        raise TypeError('contientMineCellule : Le  paramètre n’est pas une cellule')
    return cell[const.CONTENU]==const.ID_MINE

def isAnnotationCorrecte(annot:str)->bool:
    '''retourne true si annot est correcte false sinon'''
    return annot in [None,const.DOUTE,const.FLAG]

def getAnnotationCellule(cell:dict)->str:
    '''retourne l'annotation de la cellule passée en parmètre'''
    if not type_cellule(cell):
        raise TypeError(f"getAnnotationCellule : le paramètre {cell} n’est pas une cellule")
    if const.ANNOTATION not in cell:
        res=None
    else:
        res=cell[const.ANNOTATION]
    return res

def changeAnnotationCellule(cell:dict)->None:
    '''change l'annotation de la cellule'''
    if not type_cellule(cell):
        raise TypeError('changeAnnotationCellule : le paramètre n’est pas une cellule ')
    annot=[None,const.FLAG,const.DOUTE]
    actu=getAnnotationCellule(cell)
    ind=(annot.index(actu)+1)%3
    cell[const.ANNOTATION]=annot[ind]
    return None

def reinitialiserCellule(cell:dict)->None:
    '''permet de reinitialiser une cellule'''
    cell[const.CONTENU]=0
    cell[const.VISIBLE] = False
    cell[const.ANNOTATION] = None
    return None





