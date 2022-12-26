<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAIRequest;
use App\Http\Requests\UpdateAIRequest;
use App\Repositories\AIRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Orhanerday\OpenAi\OpenAi;

class AIController extends AppBaseController
{
    /** @var  AIRepository */
    private $aIRepository;

    public function __construct(AIRepository $aIRepo)
    {
        $this->aIRepository = $aIRepo;
    }

    /**
     * Display a listing of the AI.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $ai = $this->aIRepository->all();

        return view('ai.index')
            ->with('ai', $ai);
    }

    /**
     * Show the form for creating a new AI.
     *
     * @return Response
     */
    public function create()
    {
        return view('ai.create');
    }

    /**
     * Store a newly created AI in storage.
     *
     * @param CreateAIRequest $request
     *
     * @return Response
     */
    public function store(CreateAIRequest $request)
    {
        $input = $request->all();

        $aI = $this->aIRepository->create($input);

        Flash::success('AI saved successfully.');

        return redirect(route('ai.index'));
    }

    /**
     * Display the specified AI.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $aI = $this->aIRepository->find($id);

        if (empty($aI)) {
            Flash::error('AI not found');

            return redirect(route('ai.index'));
        }

        return view('ai.show')->with('aI', $aI);
    }

    /**
     * Show the form for editing the specified AI.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $aI = $this->aIRepository->find($id);

        if (empty($aI)) {
            Flash::error('AI not found');

            return redirect(route('ai.index'));
        }

        return view('ai.edit')->with('aI', $aI);
    }

    /**
     * Update the specified AI in storage.
     *
     * @param int $id
     * @param UpdateAIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAIRequest $request)
    {
        $aI = $this->aIRepository->find($id);

        if (empty($aI)) {
            Flash::error('AI not found');

            return redirect(route('ai.index'));
        }

        $aI = $this->aIRepository->update($request->all(), $id);

        Flash::success('AI updated successfully.');

        return redirect(route('ai.index'));
    }

    /**
     * Remove the specified AI from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $aI = $this->aIRepository->find($id);

        if (empty($aI)) {
            Flash::error('AI not found');

            return redirect(route('ai.index'));
        }

        $this->aIRepository->delete($id);

        Flash::success('AI deleted successfully.');

        return redirect(route('ai.index'));
    }

    public function searchOpenAI(Request $request)
    {
        try{
            $open_ai = new OpenAi(env('OPENAI_API_KEY'));

            $input = $request->all();

            $response = $open_ai->completion([
                'model' => 'text-davinci-003',
                'prompt' => $input['search'],
                'temperature' => 0.7,
                'max_tokens' => 256,
                'top_p' => 1,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
            ]);

            $output = json_decode($response,true);

            $all_text = array_column($output['choices'],'text');

            $content = "";
            foreach($all_text as $val){
                $content .= $val;
            }

            //remove first \n
            $pos = strpos($content, "\n\n");
            if ($pos !== false) {
                $content = substr_replace($content, '', $pos, strlen("\n\n"));
            }

            return response()->json(['status'=>true,'message'=>"search result",'data'=>$content]);
        } catch (\exception $e){
            return response()->json(['status'=>false,'message'=>"Error! something went wrong ".$e->getMessage()]);
        }
    }
}
