export default function Header({assistant, session}){

  return (
    <div className="text-white bg-[#090A0B] p-4 flex flex-row gap-5">
      <div>
        <img src={assistant.img !== "null"  ? assistant.img : `/img/${assistant.short_name}.jpg`}
             className="rounded-xl w-14 ml-8 bg-ai-conversation-page p-0.5"/>
      </div>
      <div className="flex flex-col justify-content-center pt-1">
        <div className="font-bold">
          Asystent
        </div>
        <div className="font-weight-light">{assistant.name}</div>
        <div className="text-[9px] text-[#2e3338]">{session}</div>
      </div>
    </div>
  );
}
