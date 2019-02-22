<?php
/**
 * Created by PhpStorm.
 * User: Kshamina
 * Date: 2/21/2019
 * Time: 1:21 PM
 */

namespace App\Enums;


class API
{
    /* ENDPOINTS */
    const HOME = "/";
    const ADMIN = "admin/";
    const ING_LIST = "ingredientList/";
    const ING = "ingredient/";
    const PROD_LIST = "productList/";
    const NEW_NFC = "newNFCId/";
    const PROD = "product/";
    const SHOP_LIST = "shoppingList/";
    const TAG = "tag/";
    const ORGANISATION = "organization/";

    /* USER RELATED ENDPOINTS AND TAGS */
    const LOGIN = "login/";
    const NEW_USER = "newUser/";
    const MANAGE_USER = "manageUser/";
    const USERNAME = "username";
    const PASSWORD = "password";
    const EMAIL = "email";
    const LEVEL = "level";
    const ORG = "organization";

    /* NEW PRODUCT ENDPOINT AND TAGS */
    const NEW_PROD = "newProduct/";
    const NEW_NAME = "new_name";
    const NEW_NFC_ID = "new_nfc_id";
    const NEW_PROD_ID = "new_product_id";
    const NEW_ING_ID = "new_ingredientId";
    const NEW_ING = "new_ingredients";
    const NEW_TAGS = "new_tags";
    const NEW_PIC = "new_picture";
    const NEW_INFO = "new_info";

    /* RESTRICTIONS ENDPOINT AND TAGS */
    const RESTRICTIONS = "restrictions/";
    const RESTRICT = "restrict";

    /* GENERIC TAGS */
    const NAME = "name";
    const NFC_ID = "nfc_id";
    const PROD_ID = "product_id";
    const ING_ID = "ingredient_id";
    const LIST_ID = "list_id";
    const ORG_ID = "org_id";
    const INFO = "info";
    const AUTH_TOKEN = "auth_token";

    /* FLAG AND POSSIBLE FLAG VALUES */
    const FLAG = "flag";
    const RESET = "reset";
    const TAGS = "tags";
    const DELETE = "DELETE";
    const REMOVE = "remove";
    const REPORT = "report";
    const NEW = "new";

    const PICTURE = "picture";
    const INGREDIENT = "ingredient";
}
