import {createBrowserRouter, Navigate} from "react-router-dom";
import Dashboard from "./Dashboard.jsx";
import DefaultLayout from "./components/DefaultLayout";
import GuestLayout from "./components/GuestLayout";
import Login from "./views/Login";
import NotFound from "./views/NotFound";
import Signup from "./views/Signup";
import Users from "./views/Users";
import UserForm from "./views/UserForm";
import Home from "./views/Home.jsx";
import AppLayout from "./components/AppLayout.jsx";
import Board from "./views/Board.jsx";
import Trader from "./views/Trader.jsx";
import ProductDescription from "./views/ProductDescription.jsx";
import Aidevs from "./views/Aidevs.jsx";
import Settings from "./views/Settings.jsx";
import AddSnippet from "./views/AddSnippet.jsx";
import Group from "./views/Group.jsx";
import MainLayout from "./components/MainLayout.jsx";
import Index from "./views/Index.jsx";
import MainAppLayout from "./components/MainAppLayout.jsx";

const router = createBrowserRouter([
  {
    path: '/',
    element: <MainAppLayout/>,
    children: [
      {
        path: '/',
        element: <Index/>,
      },
      {
        path: '/chat/:avatarName',
        element: <MainLayout/>
      },
      {
        path: '/settings',
        element: <Settings/>
      },
      {
        path: '/add/snippet',
        element: <AddSnippet/>
      },
      {
        path: '/edit/snippet/:id',
        element: <AddSnippet/>
      },
      {
        path: '/group',
        element: <Group/>
      },
    ]
  },

  // {
  //   path: '/app/',
  //   element: <AppLayout/>,
  //   children: [
  //     {
  //       path: '/',
  //       element: <Navigate to="/users"/>
  //     },
  //     {
  //       path: '/dashboard',
  //       element: <Dashboard/>
  //     },
  //     {
  //       path: '/home',
  //       element: <Home/>
  //     },
  //     {
  //       path: '/board',
  //       element: <Board/>
  //     },
  //     {
  //       path: '/trader',
  //       element: <Trader/>
  //     },
  //     {
  //       path: '/settings',
  //       element: <Settings/>
  //     },
  //     {
  //       path: '/add/snippet',
  //       element: <AddSnippet/>
  //     },
  //     {
  //       path: '/edit/snippet/:id',
  //       element: <AddSnippet/>
  //     },
  //     {
  //       path: '/group',
  //       element: <Group/>
  //     },
  //     {
  //       path: '/product-description',
  //       element: <ProductDescription/>
  //     },
  //     {
  //       path: '/aidevs',
  //       element: <Aidevs/>
  //     },
  //     {
  //       path: '/users',
  //       element: <Users/>
  //     },
  //     {
  //       path: '/users/new',
  //       element: <UserForm key="userCreate"/>
  //     },
  //     {
  //       path: '/users/:id',
  //       element: <UserForm key="userUpdate"/>
  //     }
  //   ]
  // },
  {
    path: '/',
    element: <GuestLayout/>,
    children: [
      {
        path: '/login',
        element: <Login/>
      },
      {
        path: '/signup',
        element: <Signup/>
      }
    ]
  },
  {
    path: "*",
    element: <NotFound/>
  }
])

export default router;
