<?php require ( !empty($_SERVER['DOCUMENT_ROOT']) ? ($_SERVER['DOCUMENT_ROOT'] . '/../_/_.php') : '_/_.php' );
  
  do 
  {
    if
    (
      !\_\Network\RequestLifecycle::handle
      (
        uOptions:\_\Network\RequestLifecycle::OPTION_INIT_VIEW_STATE | \_\Network\RequestLifecycle::OPTION_VIEW_STATE_FROM_REQUEST
      )
    ) break;

    /** @var \_\IO\Out\JSON $oResponse */
    $oResponse = \_\IO\Out::$_;

    {
      if ( $oUser = \_\Auth\Auth::user() AND strcasecmp($oUser->status, \£\DB\Repository\User::STATUS_GUEST) )
      {
        $oResponse->iHTTPCode    = 403;
        $oResponse->sCode        = 'USER_ALREADY_LOGGED';
        $oResponse->sDescription = 'user is already logged';

        break;
      }
    }

    {
      $sUserName = \_\IO\In\Param::string( 'user_name' ) ?: '';
      $sPassword = \_\IO\In\Param::string( 'password' )  ?: '';
    }

    {
      if ( empty($sUserName) )
        $oResponse->aErrors['user_name'] = 'cannot be empty';

      if ( empty($sPassword) )
        $oResponse->aErrors['password'] = 'cannot be empty';


      if ( $oResponse->aErrors )
      {
        $oResponse->iHTTPCode    = 400;
        $oResponse->sCode        = 'INVALID_FIELDS';
        $oResponse->sDescription = 'invalid fields';

        break;
      }
    }

    {
      $oDB   = \_\DB\MySQL::_( );
      $oUser = \_\Auth\Auth::user( );
    }

    {
      $sSQL = \_\DB\MySQL\Query::_
      (
        aFields: [ \£\DB\Table\User::TABLE_NAME.'.*', ],
        aFrom: [ \£\DB\Table\User::TABLE_NAME, ],
        aWhere:
        [
          \£\DB\Table\User::TABLE_NAME.'.user_name'  => $sUserName,
          \£\DB\Table\User::TABLE_NAME.'.deleted_at' => NULL
        ],
        iLimit: 2
      )->select( );

      $bAuthError = FALSE;

      /** @var \£\DB\Table\User $oUserFromSelect */
      if ( !$oUserFromSelect = $oDB->unique($sSQL, \£\DB\Table\User::class) )
      {
        $oResponse->iHTTPCode    = 404;
        $oResponse->sCode        = 'INVALID_USER_NAME';
        $oResponse->sDescription = 'invalid user or password';

        $bAuthError = TRUE;
      }
      else if ( !$oUserFromSelect->password || !password_verify($sPassword, $oUserFromSelect->password) )
      {
        $oResponse->iHTTPCode    = 400;
        $oResponse->sCode        = 'INVALID_USER_PASSWORD';
        $oResponse->sDescription = 'invalid user or password';

        $bAuthError = TRUE;
      }
    }

    {
      \_\Session\User::login( $oUserFromSelect->id );
    }

    {
      $oResponse->bSuccess     = TRUE;
      $oResponse->sCode        = 'OK';
      $oResponse->sDescription = 'User logged in successfully';
      $oResponse->mData        =
      [
        'auth_token' => \_\Session\ViewState::get( ),
        'user'       => $oUserFromSelect->response( NULL, ['id'] )
      ];
    }

  } while ( FALSE );
