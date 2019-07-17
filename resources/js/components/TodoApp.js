import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import TaskList from './TaskList'
import TaskInput from './TaskInput'

export default class TodoApp extends Component {
  constructor() {
    super();

    this.state = { tasks: [] }
  }

  componentDidMount() {
    axios.get('/tasks')
      .then(res => res.data.data)
      .then(tasks => this.setState({ tasks }))
  }

  render() {
    return (
      <div>
        <TaskInput />

        <TaskList tasks={this.state.tasks} />
      </div>
    )
  }
}

if (document.getElementById('todo-app')) {
  ReactDOM.render(<TodoApp />, document.getElementById('todo-app'));
}
