import {useEffect, useState} from "react";
import ErpAssistantChatMessages from "../components/ErpAssistantChatMessages.jsx";
import {useCookies} from "react-cookie";
import generateNewHash from "../core/api/GenerateNewSessionHash.js";
import scrollToBottom from "../core/utils/ScrollToBottom.js";
import {generateUniqueId} from "../../functions/Helpers.js";

export default function ErpAiAssistant() {

  const [message, setMessage] = useState("");
  const [messages, setMessages] = useState([]);
  const [sessionHash, setSessionHash] = useState("");
  const [canSendMessage, setCanSendMessage] = useState(true);
  const [cookies, setCookie, removeCookie] = useCookies(["sessionHash"]);

  useEffect(() => {
    generateNewHash(setSessionHash, setCookie);
  }, ['']);

  const sendMessage = async (event) => {
    // const value = event.target.value;
    const newMessage = {
      sender: "me",
      message: {original: message},
      date: new Date(),
      id: generateUniqueId(messages),
      translated: false,
      loaded: true,
    };

    const aiMessage = {
      sender: "ai",
      message: {original: ''},
      date: new Date(),
      id: generateUniqueId(messages),
      translated: false,
      loaded: false,
    };
    setMessages((messages) => [...messages, newMessage]);
    await generateResponseAi(aiMessage, message);

  }

  const generateResponseAi = async (aiMessage, message, payload) => {
    // setMessage(message);
    setMessages((messages) => [...messages, aiMessage]);
    await generateResponse(aiMessage, null, payload);
  }

  const generateResponse = async (aiMessage, id = null, payload = null) => {
    setCanSendMessage(false);

    if (payload == null) {
      payload = {
        message: message,
        session: sessionHash
      };
    }


    // let id = generateUniqueId(messages);
    // ====  CHAT GPT  ====
    const token = localStorage.getItem('ACCESS_TOKEN');
    const response = await fetch(`${import.meta.env.VITE_API_BASE_URL}/api/erp/message/new`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${token}`,
      },
      body: JSON.stringify(payload),
    });

    const reader = response.body.getReader();
    const textDecoder = new TextDecoder("utf-8");

    let messageBuffer = "";

    const processMessage = (message) => {
      if (message.startsWith("data:")) {
        const data = JSON.parse(message.slice("data:".length).trim());
        if (typeof data.id !== "undefined") {
          id = data.id;
        }
        if (typeof data.delta.content !== "undefined") {
          setMessages((messages) =>
            messages.map((m) =>
              m.id === aiMessage.id
                ? {...m, message: {original: m.message.original + data.delta.content}, loaded: true}
                : m
            )
          );
        }
      }
    };

    const readStream = async () => {
      try {
        const {done, value} = await reader.read();
        if (done) {
          return;
        }

        const textChunk = textDecoder.decode(value);
        const messages = (messageBuffer + textChunk).split("\n");

        // == Normal message is returned then display it (not chatgpt)
        try {
          if (Array.isArray(messages)) {
            const jsonString = messages[0];
            const response = JSON.parse(jsonString);
            if ('view' in response) {
              setMessages((messages) =>
                messages.map((m) =>
                  m.id === aiMessage.id
                    ? {...m, message: {original: response.view}, loaded: true}
                    : m
                )
              );

              // Jeśli zwracana many Response to je wykonuje
              handleManyResponse(response);
              // Jeśli zwracana many Response to je wykonuje
              setMessage("");
              setCanSendMessage(true);
              return true;
            }
          }
        } catch (error) {
        }
        // == Normal message is returned then display it (not chatgpt)

        messageBuffer = messages.pop();
        messages.forEach(processMessage);
        scrollToBottom('chatBox');
        await readStream();
        scrollToBottom('chatBox');
        messages.map((m) =>
          m.id === aiMessage.id
            ? {...m, message: {id: id}, loaded: true}
            : m
        )

      } catch (error) {
        console.error("Error reading stream:", error);
      }
    };

    await readStream();
    // ====  CHAT GPT  ====
    // getLinkForMessage(message, assistantId, aiMessage);
    // getMessagesConversation();
    setMessage("");
    setCanSendMessage(true);
  }


  return (
    <div className="full-no-margin bg-[#EFF3F6] text-black">
      <div className="relative">
        <div aria-hidden="true" className="absolute top-0 left-0 right-0 h-72 z-[-1] opacity-20 pointer-events-none">
          <div className="fade-in">
            <canvas height="288" width="1601"></canvas>
          </div>
        </div>
        <div className="h-1 bg-gradient-to-r from-[#9867f0] to-[#ed4e50]"></div>
        {/*<header className="p-4">*/}
        {/*  <div className="flex items-center justify-between">*/}
        {/*    ERP*/}
        {/*    <nav className="space-x-4 text-sm text-gray-800 flex"><a*/}
        {/*      className="hover:underline flex items-center space-x-1.5" href="https://twitter.com/githubnext">*/}
        {/*      <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em"*/}
        {/*           width="1em" xmlns="http://www.w3.org/2000/svg">*/}
        {/*        <path*/}
        {/*          d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path>*/}
        {/*      </svg>*/}
        {/*      <span>Twitter</span></a><a className="hover:underline flex items-center space-x-1.5"*/}
        {/*                                 href="https://gh.io/next-discord">*/}
        {/*      <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 640 512"*/}
        {/*           className="mt-0.5 w-4" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">*/}
        {/*        <path*/}
        {/*          d="M524.531,69.836a1.5,1.5,0,0,0-.764-.7A485.065,485.065,0,0,0,404.081,32.03a1.816,1.816,0,0,0-1.923.91,337.461,337.461,0,0,0-14.9,30.6,447.848,447.848,0,0,0-134.426,0,309.541,309.541,0,0,0-15.135-30.6,1.89,1.89,0,0,0-1.924-.91A483.689,483.689,0,0,0,116.085,69.137a1.712,1.712,0,0,0-.788.676C39.068,183.651,18.186,294.69,28.43,404.354a2.016,2.016,0,0,0,.765,1.375A487.666,487.666,0,0,0,176.02,479.918a1.9,1.9,0,0,0,2.063-.676A348.2,348.2,0,0,0,208.12,430.4a1.86,1.86,0,0,0-1.019-2.588,321.173,321.173,0,0,1-45.868-21.853,1.885,1.885,0,0,1-.185-3.126c3.082-2.309,6.166-4.711,9.109-7.137a1.819,1.819,0,0,1,1.9-.256c96.229,43.917,200.41,43.917,295.5,0a1.812,1.812,0,0,1,1.924.233c2.944,2.426,6.027,4.851,9.132,7.16a1.884,1.884,0,0,1-.162,3.126,301.407,301.407,0,0,1-45.89,21.83,1.875,1.875,0,0,0-1,2.611,391.055,391.055,0,0,0,30.014,48.815,1.864,1.864,0,0,0,2.063.7A486.048,486.048,0,0,0,610.7,405.729a1.882,1.882,0,0,0,.765-1.352C623.729,277.594,590.933,167.465,524.531,69.836ZM222.491,337.58c-28.972,0-52.844-26.587-52.844-59.239S193.056,219.1,222.491,219.1c29.665,0,53.306,26.82,52.843,59.239C275.334,310.993,251.924,337.58,222.491,337.58Zm195.38,0c-28.971,0-52.843-26.587-52.843-59.239S388.437,219.1,417.871,219.1c29.667,0,53.307,26.82,52.844,59.239C470.715,310.993,447.538,337.58,417.871,337.58Z"></path>*/}
        {/*      </svg>*/}
        {/*      <span>Discord</span></a>*/}
        {/*    </nav>*/}
        {/*  </div>*/}
        {/*</header>*/}
      </div>
      <div className="pt-10 pb-40">
        <div className="pt-10 pb-40">
          <div
            className="max-w-[min(60em,98vw)] bg-white border shadow-lg mx-auto md:py-8 py-[4em] grid lg:grid-cols-[2em,4em,1fr,4em,2em] md:grid-cols-[2em,2vw,1fr,2vw,2em] grid-cols-[3vw,3vw,1fr,3vw,3vw] text-sm md:text-base lg:text-lg">
            <div className="col-start-3">
              <label htmlFor="large-input" className="block mb-2 text-sm font-medium text-gray-500 dark:text-white">Message</label>

              <div className="mb-6 flex flex-row grow-[2]">
                <textarea
                  type="text" id="large-input"
                  className="mr-3 w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  value={message}
                  onChange={(event) => setMessage(event.target.value)}
                ></textarea>
                <button
                  type="submit"
                  className="text-gray-700 bg-gray-100 focus:ring-4 border border-gray-300 hover:border-gray-400 font-medium rounded-lg text-sm px-4 py-2"
                  onClick={sendMessage}
                >Send</button>

              </div>

            </div>
          </div>


          <div className="overflow-y-auto mb-5" id="chatBox">

            {/*Messages*/}

            <ErpAssistantChatMessages messages={messages} response={generateResponse}/>

            {/*Messages*/}

          </div>



        </div>
      </div>
    </div>
  )
}