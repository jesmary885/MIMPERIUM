<?php

namespace App\Http\Livewire\Admin;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class GenealogiaResidual extends Component
{

    use WithPagination;

    protected $paginationTheme = "bootstrap";

    protected $listeners = ['render' => 'render'];

    public function updatingSearch(){
        $this->resetPage();
    }

    public $user, $referidos, $refers, $cant;
    public $gl1, $gl2, $gl3, $gl4, $gl5, $gl6, $gt;

   /* public function mount(){
        $this->user =  Auth::user();

        $this->referidos = Partner::where('refer_id',$this->user->id)->get();

        $ptos_l1 = 0;
        foreach ($this->referidos as $ref1){
            $ptos_l1 = (User::where('id',$ref1->user_id)->first()->points) + $ptos_l1;
        }

        $this->gl1 = (5 * $ptos_l1 ) / 100;
        $this->gt = $this->gl1;
    }*/

    public function count($value){
        return Partner::where('refer_id',$value)->count();

    }

    public function ganancia_puntos(){
        return ($this->user->points * 40)/100;
    }

  /* public function ganancia($value,$nivel){
        $refer = Partner::where('refer_id',$value)->get();

        $ptos = 0;
        foreach ($refer as $ref){
            $ptos = (User::where('id',$ref->user_id)->first()->points) + $ptos;
        }

        if($nivel == 2){
           $this->gl2 = (6 * $ptos ) / 100;
        }

        if($nivel == 3){
            $this->gl3 = (7 * $ptos ) / 100;
        }

        if($nivel == 4){
            $this->gl4 = (8 * $ptos ) / 100;
        }

        if($nivel == 5){
            $this->gl5 = (9 * $ptos ) / 100;
        }

        if($nivel == 6){
            $this->gl6 = (10 * $ptos ) / 100;
        }
    }*/

    public function nivel($value){
        $user_refer = Partner::where('user_id',$value)->first(); //ubico a la persona en tabla partner
        $cont = 1;
        $act = 0;

        do{
            if($cont == 1){//busco el primer patrocinador por encima de él
                $user_refer2 = Partner::where('user_id',$user_refer->refer_id)->first();
            }
        
            if($user_refer2->refer_id == auth()->id()) {
                $act=1;
                $cont = $cont + 1;
            }

            else{
                $act=0;
                $cont = $cont + 1;
                //voy a buscar el patrocinador de su patrocinador
                $user_refer2 = Partner::where('user_id',$user_refer2->refer_id)->first();
            }
        }
        while($act == 0);

        return $cont;
    }

    public function partner_name ($value){
        $user_refer = Partner::where('user_id',$value)->first();

       /* if($user_refer->isEmpty()) return '-';
        else return $user_refer->refer->name;*/

        if($user_refer) return $user_refer->user->name;
        else return '-';

    }

    public function partner_code ($value){
        $user_refer = Partner::where('user_id',$value)->first();

        if($user_refer) return $user_refer->user->code;
        else return '-';

    }


    public function refers($value){
        $this->refers = Partner::with('refer')->where('refer_id',$value)->get();
        
       if($this->refers->isEmpty()) return 0;
        else return $this->refers;
    }

    public function render()
    {
        $refers_direct = Partner::with('refer')
            ->where('refer_id',auth()->id())
            ->paginate(1);


        return view('livewire.admin.genealogia-residual',compact('refers_direct'));
    }
}
