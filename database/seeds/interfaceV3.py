import mysql.connector
import random

mydb = mysql.connector.connect(
    host ="localhost",
    user="kyle",
    password="password",
    database='ProjectDB'
    
)
mycursor = mydb.cursor()
def main():
    #print("select the database to view")
   # mycursor.execute("SELECT DATABASE()")
   # print(mycursor)
    #y = 1
   # for x in mycursor:
    #    print(y,x)
    #    y= y+1
    
    #for x in mycursor:
   #     print(x)

    #add_ingredent("Chicken Broth")
    #add_product("Chicken Soup")
    #print(get_ingredent_id("Chicken Broth"))
    #show_table("Ingredent")
    #show_table("Product")
    #link_ingredent_product("Chicken Soup", "Chicken Broth")
    #get_ingredents_name("Chicken Soup")

def create_nfc_tag_id():
    while(1):
        y = random.randint(1, 100000)
        mycursor.execute("SELECT p.product_id FROM Product as p WHERE p.nfc_id = %s"%(str(y)))
        list =[]
        for x in mycursor:
            list.append(x)
        if len(list) == 0:
            return y


def add_product(productname):
    mycursor.execute("SELECT p.product_id FROM Product as p WHERE p.name = '%s'"%(productname))
    list =[]
    for x in mycursor:
        list.append(x)
    if (len(list) > 0):
        y = list[0]
    if (len(list) == 0):
        mycursor.execute("INSERT IGNORE INTO Product (nfc_id, name) VALUES ('%s', '%s')"%(str(create_nfc_tag_id()),(productname)))

def get_product_id(productname):
    mycursor.execute("SELECT p.product_id FROM Product as p WHERE p.name = '%s'"%(productname))
    list =[]
    for x in mycursor:
        list.append(x)
    y = list[0]
    return int(y[0])

def add_ingredent_product(productname, ingredentname):
    x = get_product_id(productname)
    y = get_ingredent_id(ingredentname)
    mycursor.execute("INSERT IGNORE INTO Product_Ingredent VALUES (%i, %i)"%(x, y))

def printCurser(mycursor):
    for x in mycursor:
            print(x)

def get_product_name(productID):
    mycursor.execute("SELECT p.name FROM Product as p WHERE p.product_id = '%s'"%(productID))
    for x in mycursor:
        print(x)
    
def add_ingredent(ingredentname):
    mycursor.execute("SELECT i.ingredent_id FROM Ingredent as i WHERE i.name = '%s'"%(ingredentname))
    list =[]
    for x in mycursor:
        list.append(x)
    if (len(list) > 0):
        y = list[0]
    if (len(list) == 0):
        mycursor.execute("INSERT IGNORE INTO Ingredent (name) VALUES ('%s');"%(ingredentname))

def get_ingredent_id(ingredentname):
    mycursor.execute("SELECT i.ingredent_id FROM Ingredent as i WHERE i.name = '%s'"%(ingredentname))
    list =[]
    for x in mycursor:
        list.append(x)
    y=list[0]
    return int(y[0])

def show_table(tablename):
    mycursor.execute("SELECT * from %s"%(tablename))
    printCurser(mycursor)

def get_ingredents_productid(product):
    list = []
    mycursor.execute("SELECT p.name, i.name, i.product_id FROM Ingredent as i INNER JOIN Product_Ingredent as pi ON pi.ingredent_id = i.ingredent_id INNER JOIN Product as p ON p.product_id = pi.product_id WHERE p.product_id = %i;"%(product))
    for pname,iname,iprod in mycursor:
        print(pname,iname)
        if iprod is not None:
            list.append(iprod)
    for i in list:
        get_ingredents_productid(i)

def get_ingredents_name(product):
    list =[]
    mycursor.execute("SELECT p.name, i.name, i.product_id FROM Ingredent as i INNER JOIN Product_Ingredent as pi ON pi.ingredent_id = i.ingredent_id INNER JOIN Product as p ON p.product_id = pi.product_id WHERE p.name = '%s';"%(product))
    for pname,iname,iprod in mycursor:
        print(pname,iname,iprod)
        if iprod is not None:
            list.append(iprod)
    for i in list:
        get_ingredents_productid(i)
def add_restriction(restrictionName, severity):
    mycursor.execute("SELECT r.restriction_id FROM Restriction as r WHERE r.restrictionName = '%s'"%(restrictionName))
    list =[]
    for x in mycursor:
        list.append(x)
    if (len(list) > 0):
        print("there is already a restriction of that name")
    if (len(list) == 0):
        mycursor.execute("INSERT IGNORE INTO Restriction(restrictionName, restrictionSeverity) VALUES ('%s',%i)"%(restrictionName, severity))

def get_restriction_id(restrictionName):
    mycursor.execute("SELECT r.restriction_id FROM Restriction as r WHERE r.restrictionName = '%s'"%(restrictionName))
    list =[]
    for x in mycursor:
        list.append(x)
    y = list[0]
    return int(y[0])

def add_ingredent_restriction(restrictionName, ingredentName):
    x = get_restriction_id(restrictionName)
    y = get_ingredent_id(ingredentName)
    mycursor.execute("INSERT IGNORE INTO Restriction_Ingredent VALUES (%i, %i)"%(x, y))

def add_user(userName):
    mycursor.execute("INSERT IGNORE INTO Person(user_data) VALUES ('%s')"%(userName))

def get_user_id(userName):
    mycursor.execute("SELECT u.user_id FROM Person as u WHERE u.user_data = '%s'"%(userName))
    list =[]
    for x in mycursor:
        list.append(x)
    y = list[0]
    return int(y[0])

def add_user_restriction(user_id, restriction_id):
    mycursor.execute("INSERT IGNORE INTO Person_Restriction VALUES (%i, %i)"%(user_id, restriction_id))

def get_user_restrictions(user_id):
    mycursor.execute("SELECT s.restriction_id FROM Person as p INNER JOIN Person_Restriction as s ON p.user_id = s.user_id WHERE p.user_id = %i"%(user_id))
    list =[]
    for x in mycursor:
        list.append(x)
    y = []
    for l in list:
        y.append(int(l[0]))
    return y
        
def get_listID(listLink):
    mycursor.execute("SELECT s.list_id FROM ShoppingList as s WHERE s.list_link = '%s'"%(listLink))
    list = []
    for x in mycursor:
        list.append(x)
    y = list[0]
    return int(y[0])
def add_ShoppingList(userId):
    z = str(generate_List_Link())
    list =[]
    mycursor.execute("INSERT IGNORE INTO ShoppingList(list_link) VALUES ('%s')"%(z))
    listid = get_listID(z)
    mycursor.execute("INSERT IGNORE INTO Person_ShoppingList VALUES (%i,%i)"%(userId, listid))
    return listid

def generate_List_Link():
    while(1):
        y = random.randint(1, 100000)
        mycursor.execute("SELECT s.list_id FROM ShoppingList as s WHERE s.list_link = %s"%(str(y)))
        list =[]
        for x in mycursor:
            list.append(x)
        if len(list) == 0:
            return y

def get_users_shoppingLists(userId):
    mycursor.execute("SELECT s.list_id FROM Person as p INNER JOIN Person_ShoppingList as s ON p.user_id = s.user_id WHERE p.user_id = %i"%(userId))
    list =[]
    for x in mycursor:
        list.append(x)
    y = []
    for l in list:
        y.append(int(l[0]))
    return y

def add_product_shoppingList(list_id, product_id):
    mycursor.execute("INSERT IGNORE INTO ShoppingList_Product VALUES (%i, %i)"%(list_id, product_id))

def get_products_shoppingList(list_id):
    mycursor.execute("SELECT p.name FROM ShoppingList as s INNER JOIN ShoppingList_Product as sp ON sp.list_id = s.list_id INNER JOIN Product as p ON p.product_id = sp.product_id WHERE s.list_id = %i"%(list_id))
    list =[]
    for x in mycursor:
        list.append(x)
    y = []
    for l in list:
        y.append(l[0])
    return y

def get_ingredents_restriction(restrictionName):
    mycursor.execute("SELECT i.name FROM Restriction as r INNER JOIN Restriction_Ingredent as ri ON ri.restriction_id = r.restriction_id INNER JOIN Ingredent as i ON i.ingredent_id = ri.ingredent_id WHERE r.restrictionName = '%s'"%(restrictionName))
    
    list =[]
    for x in mycursor:
        list.append(x)
    y = []
    for l in list:
        y.append(l[0])
    return y

def exit():
    mydb.commit()
    mycursor.close()
    mydb.close()


main()
