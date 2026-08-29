<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AgeVerificationController extends Controller
{
public function verify(Request $request)
{
    $verified = (bool) $request->input('age_verified');
    
    // Captura o código de afiliação diretamente da request
    $affiliateCode = $request->input('code');

    \Log::info('Age Verification Debug', [
        'verified' => $verified,
        'affiliate_code' => $affiliateCode,
        'full_request' => $request->all()
    ]);

    if ($verified) {
        // Armazena na sessão que o usuário verificou a idade
        session(['show_age_verification' => false]);
        
        // Armazena o código de afiliação na sessão, se existir
        if ($affiliateCode) {
            session(['affiliate_code' => $affiliateCode]);
            
            \Log::info('Affiliate Code Stored in Session', [
                'code' => $affiliateCode,
                'session_code' => session('affiliate_code')
            ]);
        }

        // Retorna uma resposta JSON para fechar o modal
        return response()->json([
            'status' => 'success', 
            'code' => $affiliateCode
        ]);
    } else {
        // Se for menor de idade, redireciona para uma página de aviso
        return response()->json(['status' => 'denied']);
    }
}
}