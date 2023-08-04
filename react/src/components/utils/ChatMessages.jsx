import PerfectScrollbar from "react-perfect-scrollbar";
import ReactMarkdown from "react-markdown";
import remarkGfm from 'remark-gfm';
import rehypeHighlight from 'rehype-highlight';
import rehypePrism from "rehype-prism";
import rehypeRaw from "rehype-raw";
import TestOpenApi from "../TestOpenApi.jsx";


export default function ChatMessages({messages, regenerate, avatar}) {

  return (
      <div className="overflow-y-auto">
        <div className="messagesBox">
          {messages.map(message => {
            const isAi = message.sender === "ai";

            return (
              <div className="mx-2 sm:mx-8 my-6 text-md pb-12 message" key={message.id}>
                <div className={isAi ? 'bg-ai-conversation-ai rounded-xl p-4 sm:p-8 pb-10 sm:pb-10' : 'bg-ai-conversation-me rounded-xl border border-ai-conversation-border p-4 sm:p-8 text-right'}>
                  <div>

                    {
                      message && message.message && message.message.original !== null && isAi ? (

                        <ReactMarkdown
                          remarkPlugins={[remarkGfm]}
                          rehypePlugins={[rehypeHighlight, rehypePrism, rehypeRaw]}
                          children={message.loaded ? message.message.original : '<div className="ml-8 dot-flashing text-white"/>'}
                        />
                      ) : (
                        message.loaded ? message.message.original : <div className="ml-8 dot-flashing text-white"/>
                      )
                    }

                  </div>
                </div>

                {
                  isAi ? (
                    <div className="flex justify-between">
                      <img src={avatar.img !== "null"  ? avatar.img : `/img/${avatar.short_name}.jpg`}
                           className="rounded-xl w-24 ml-8 bg-ai-conversation-page p-0.5" style={{marginTop: -1.5 + 'em'}}/>

                      <div className="mt-2 items-center flex gap-3  mr-3">
                        {/*<p className="font-light">Just now</p>*/}
                        <div
                          onClick={() => navigator.clipboard.writeText(message.message.original)}
                          className="flex h-fit items-center select-none cursor-pointer gap-1 font-semibold bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 group-hover:bg-gray-200 dark:group-hover:bg-gray-600 rounded px-2 py-0.5 p-1 text-xs">
                          Copy
                        </div>
                        <div
                          onClick={() => regenerate(message)}
                          className="flex h-fit items-center select-none cursor-pointer gap-1 font-semibold bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 group-hover:bg-gray-200 dark:group-hover:bg-gray-600 rounded px-2 py-0.5 p-1 text-xs">
                          Regenerate response
                        </div>
                      </div>
                    </div>
                  ) : (
                    <div className="flex justify-end mr-3">
                      <div className="mt-2 items-center flex gap-3">
                        {/*<p className="font-light">Just now</p>*/}
                      </div>
                    </div>
                  )
                }

              </div>

            );
          })}


          {/*<TestOpenApi />*/}

          {/*<div className="mx-2 sm:mx-8 my-6 text-md pb-12 message">*/}
          {/*  <div className="bg-ai-conversation-ai rounded-xl p-4 sm:p-8 pb-10 sm:pb-10">*/}
          {/*    <div>*/}

          {/*      <h2 className="text-2xl font-bold tracking-tight text-white sm:text-2xl mb-2">Generuj:</h2>*/}

          {/*      <div className="flex flex-col">*/}

          {/*       dssd*/}

          {/*      </div>*/}
          {/*    </div>*/}
          {/*  </div>*/}
          {/*</div>*/}


        </div>
      </div>

  );
}
